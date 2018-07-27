<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 5:55
 */

class SagawaAPI
{
    private $curl;
    private $SAGAWA_API_BASE_URL = "http://tsuisekiapi.mydns.jp/traking/sagawa/?number=";
    public $name = "sagawa";

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function run(string $number)
    {
        $url = $this->parseUrl($number);

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($this->curl);

        $jsonRes = json_decode($res);

        curl_close($this->curl);

        return $jsonRes;
    }

    private function parseUrl(string $number)
    {
        return $this->SAGAWA_API_BASE_URL.$number;
    }
}