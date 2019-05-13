<?php

namespace djstarcom\FBAccountKit\Interfaces;

/**
 * Interface ConfigInterface
 * @package djstarcom\FBAccountKit\Interfaces
 */
interface ConfigInterface
{
    /**
     * @return string
     */
    public function getUrlToken();

    /**
     * @return string
     */
    public function getUrlMe();

    /**
     * @return string
     */
    public function getUrlLogout();

    /**
     * @param $accountId
     * @return string
     */
    public function getUrlInvalidateAllTokens($accountId);

    /**
     * @param $accountId
     * @return string
     */
    public function getUrlDelete($accountId);

    /**
     * @return string
     */
    public function getUrlAccounts();

    /**
     * @return string
     */
    public function getAppId();

    /**
     * @return string
     */
    public function getAppSecret();

    /**
     * @return bool
     */
    public function isSecretProof();
}
