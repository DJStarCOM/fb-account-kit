<?php

namespace djstarcom\FBAccountKit\Interfaces;

/**
 * Interface AccountKitInterface
 * @package djstarcom\FBAccountKit\Interfaces
 */
interface AccountKitInterface
{
    /**
     * @param $code
     * @return mixed
     */
    public function getAccessToken($code);

    /**
     * @param $accessToken
     * @return mixed
     */
    public function getData($accessToken);

    /**
     * @param $accessToken
     * @return mixed
     */
    public function logout($accessToken);

    /**
     * @param $accountId
     * @return mixed
     */
    public function invalidateAllTokens($accountId);

    /**
     * @param $accountId
     * @return mixed
     */
    public function deleteAccount($accountId);

    /**
     * @param int $limit Number of users on the data page.
     * @return mixed
     */
    public function getAccounts($limit = 20);
}
