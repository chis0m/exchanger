<?php

namespace App\Services\ThirdParty\Exchange;

use App\Traits\HttpClient;
use Exception;

class FixerSocket
{
    private $baseUrl;
    private $apiKey;
    private $header;

    public function __construct()
    {
        $this->baseUrl = "http://data.fixer.io/api";
        $this->apiKey = config('api.fixer.api_key');
        $this->header = ['content-type' => 'application/json'];
    }

    public function getCurrencySymbols()
    {
        try {
            $url = $this->baseUrl . '/symbols';
            $params = ['access_key' => $this->apiKey];
            $response = HttpClient::request($url, 'GET', $params, $this->header);
            return $response->json()['symbols'];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
