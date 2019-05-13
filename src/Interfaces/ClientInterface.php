<?php

namespace djstarcom\FBAccountKit\Interfaces;

/**
 * Interface ClientInterface
 * @package djstarcom\FBAccountKit\Interfaces
 */
interface ClientInterface
{
    /**
     * @param $method
     * @param $url
     * @param $params
     * @return mixed
     */
    public function request($method, $url, $params);
}
