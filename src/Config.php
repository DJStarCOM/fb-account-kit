<?php

namespace djstarcom\FBAccountKit;

use djstarcom\FBAccountKit\Exceptions\InvalidConfigException;
use djstarcom\FBAccountKit\Interfaces\ConfigInterface;

/**
 * Class Config
 * @package djstarcom\FBAccountKit
 */
class Config implements ConfigInterface
{
    const ACCESS_TOKEN_URL = 'https://graph.accountkit.com/:version/access_token';
    const ME_URL = 'https://graph.accountkit.com/:version/me';
    const LOGOUT_URL = 'https://graph.accountkit.com/:version/logout';
    const INVALIDATE_ALL_TOKENS_URL = 'https://graph.accountkit.com/:version/:account_id/invalidate_all_tokens';
    const DELETE_URL = 'https://graph.accountkit.com/:version/:account_id';
    const ACCOUNTS_URL = 'https://graph.accountkit.com/:version/:app_id/accounts';

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var bool
     */
    private $secretProof = false;

    /**
     * @var string
     */
    private $version = 'v1.1';

    /**
     * Config constructor.
     * @param $params
     */
    public function __construct($params)
    {
        if (!isset($params['app_id'], $params['secret'])) {
            throw new InvalidConfigException('Invalid arguments for config');
        }

        $this->secret      = $params['secret'];
        $this->appId       = $params['app_id'];
        $this->version     = isset($params['version']) ? $params['version'] : $this->version;
        $this->secretProof = isset($params['secret_proof']) ? $params['secret_proof'] : $this->secretProof;

    }

    /**
     * @return string
     */
    public function getUrlToken()
    {
        return strtr(self::ACCESS_TOKEN_URL, [
            ':version' => $this->version
        ]);
    }

    /**
     * @return string
     */
    public function getUrlMe()
    {
        return strtr(self::ME_URL, [
            ':version' => $this->version
        ]);
    }

    /**
     * @return string
     */
    public function getUrlLogout()
    {
        return strtr(self::LOGOUT_URL, [
            ':version' => $this->version
        ]);
    }

    /**
     * @param $accountId
     * @return string
     */
    public function getUrlInvalidateAllTokens($accountId)
    {
        return strtr(self::INVALIDATE_ALL_TOKENS_URL, [
            ':version'    => $this->version,
            ':account_id' => $accountId
        ]);
    }

    /**
     * @param $accountId
     * @return string
     */
    public function getUrlDelete($accountId)
    {
        return strtr(self::DELETE_URL, [
            ':version'    => $this->version,
            ':account_id' => $accountId
        ]);
    }

    /**
     * @return string
     */
    public function getUrlAccounts()
    {
        return strtr(self::ACCOUNTS_URL, [
            ':version' => $this->version,
            ':app_id'  => $this->appId
        ]);
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this->secret;
    }

    /**
     * @return bool
     */
    public function isSecretProof()
    {
        return $this->secretProof;
    }

}
