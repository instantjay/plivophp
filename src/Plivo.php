<?php

namespace instantjay\PlivoPHP;

class Plivo {
    private $apiUrl;
    private $authId;
    private $authToken;
    private static $apiVersion = 'v1';

    public function __construct($authId, $authToken) {
        $this->apiUrl = 'https://api.plivo.com/';
        $this->authId = $authId;
        $this->authToken = $authToken;
    }

    private function CreateClient() {
        $httpClient = new \Guzzle\Http\Client($this->apiUrl);
        $httpClient->setUserAgent('PHPPlivo');

        return $httpClient;
    }

    /**
     * @param Array $params
     * @return \Guzzle\Http\Message\Response
     */
    public function SendMessage($params) {
        $params = json_encode($params);

        $header = array();
        $header[] = new \Guzzle\Http\Message\Header('content-type', 'application/json');
        $header[] = new \Guzzle\Http\Message\Header('Connection', 'close');

        $httpClient = $this->CreateClient();

        $request = $httpClient->post("/".self::$apiVersion."/Account/" . $this->authId . "/Message/", $header, $params);
        $request->setAuth($this->authId, $this->authToken);

        return $request->send();
    }
}