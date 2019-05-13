<?php

namespace djstarcom\FBAccountKit;

use djstarcom\FBAccountKit\Exceptions\ResponseException;
use djstarcom\FBAccountKit\Interfaces\AccountKitInterface;
use djstarcom\FBAccountKit\Interfaces\ClientInterface;
use djstarcom\FBAccountKit\Interfaces\ConfigInterface;

/**
 * Class AccountKit
 * @package djstarcom\FBAccountKit
 */
class AccountKit implements AccountKitInterface
{
    /**
     * @var \djstarcom\FBAccountKit\Interfaces\ConfigInterface
     */
    protected $config;

    /**
     * @var \djstarcom\FBAccountKit\Interfaces\ClientInterface
     */
    protected $client;

    /**
     * AccountKit constructor.
     * @param \djstarcom\FBAccountKit\Interfaces\ConfigInterface $config
     * @param \djstarcom\FBAccountKit\Interfaces\ClientInterface $client
     */
    public function __construct(ConfigInterface $config, ClientInterface $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param $code
     * @return mixed
     * @throws \HttpResponseException
     */
    public function getAccessToken($code)
    {
        $response = $this->call('GET', $this->config->getUrlToken(), [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'access_token' => $this->prepareAccessToken(),
        ]);

        if (!isset($response['access_token'])) {
            throw new HttpResponseException('Access token not found');
        }

        return $response['access_token'];
    }

    /**
     * @param $accessToken
     * @return mixed
     */
    public function getData($accessToken)
    {
        return $this->call('GET', $this->config->getUrlMe(), $this->getParams($accessToken));
    }

    /**
     * Exiting the session.
     *
     * @param $accessToken
     * @return mixed
     */
    public function logout($accessToken)
    {
        return $this->call('POST', $this->config->getUrlLogout(), $this->getParams($accessToken));
    }

    /**
     * @param $accountId
     * @return mixed
     */
    public function invalidateAllTokens($accountId)
    {
        return $this->call('POST', $this->config->getUrlInvalidateAllTokens($accountId), [
            'access_token' => $this->prepareAccessToken(),
        ]);
    }

    /**
     * Account deleting.
     *
     * @param $accountId
     * @return mixed
     */
    public function deleteAccount($accountId)
    {
        return $this->call('DELETE', $this->config->getUrlDelete($accountId), [
            'access_token' => $this->prepareAccessToken(),
        ]);
    }

    /**
     * Retrieving Users Data.
     *
     * @param int $limit Number of users on the data page.
     * @return mixed
     */
    public function getAccounts($limit = 20)
    {
        return $this->call('GET', $this->config->getUrlAccounts(), [
            'access_token' => $this->prepareAccessToken(),
            'limit' => $limit
        ]);
    }

    /**
     * Get the application secret code.
     *
     * @param $accessToken
     * @return string|null
     */
    protected function getSecretProof($accessToken)
    {
        if ($this->config->isSecretProof()) {
            return hash_hmac('sha256', $accessToken, $this->config->getAppSecret());
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    protected function prepareAccessToken()
    {
        $appId = $this->config->getAppId();
        $appSecret = $this->config->getAppSecret();
        $appAccessToken = implode('|', ['AA', $appId, $appSecret]);

        return $appAccessToken;
    }

    /**
     * Send request.
     *
     * @param $method
     * @param $url
     * @param $params
     * @return mixed
     */
    protected function call($method, $url, $params)
    {
        $response = $this->client->request($method, $url, $params);

        if (isset($response['error'])) {
            throw new ResponseException($response['error']['message']);
        }

        return $response;
    }

    /**
     * Prepare params with appsecret_proof.
     *
     * @param $accessToken
     * @return array
     */
    protected function getParams($accessToken)
    {
        return array_filter(array_merge(
            ['access_token' => $accessToken],
            ['appsecret_proof' => $this->getSecretProof($accessToken)]
        ));
    }
}
