<?php

namespace App\Services\ThirdParty\Exchange;

use App\Models\Configuration;
use App\Traits\HttpClient;
use Exception;

class FixerSocket
{
    private $baseUrl;
    private $apiKey;
    private $header;
    private $params;

    public function __construct()
    {
        $this->baseUrl = "http://data.fixer.io/api";
        $this->apiKey = config('api.fixer.api_key');
        $this->header = ['content-type' => 'application/json'];
        $this->params = ['access_key' => $this->apiKey];
    }

    public function getCurrencySymbols()
    {
        try {
            $url = $this->baseUrl . '/symbols';
            $response = HttpClient::request($url, 'GET', $this->params, $this->header);
            return $response->json()['symbols'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getLatestExchangeRate($symbol)
    {
        try {
            $url = $this->baseUrl . '/latest';
            $numberOfCurrencies = Configuration::config('number_of_currencies');
            if ($numberOfCurrencies == 'any') {
                $this->params['base'] = $symbol;
            }
            $response = HttpClient::request($url, 'GET', $this->params, $this->header);
            return $response->json()['rates'];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
