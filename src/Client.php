<?php

namespace djstarcom\FBAccountKit;

use djstarcom\FBAccountKit\Interfaces\ClientInterface;

/**
 * Class Client
 * @package djstarcom\FBAccountKit
 */
class Client implements ClientInterface
{
    /**
     * @param $method
     * @param $url
     * @param $params
     * @return mixed
     */
    public function request($method, $url, $params)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        $data = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $data;
    }
}
