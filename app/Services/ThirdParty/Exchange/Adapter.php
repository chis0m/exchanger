<?php

namespace App\Services\ThirdParty\Exchange;

use App\Models\Configuration;
use Exception;

class Adapter
{
    private $provider;

    public function __construct()
    {
        $this->provider = $this->getExchangeProvider() ?? 'fixer';
    }

    public function getCurrencies()
    {
        try {
            $result = null;
            switch ($this->provider) {
                case 'fixer':
                    $result =  (new FixerSocket())->getCurrencySymbols();
                    break;
                case 'anohter_provider':
                    break;
                default:
                    $result = null;
                    break;
            }

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getLatestExchangeRate($symbol)
    {
        try {
            $result = null;
            switch ($this->provider) {
                case 'fixer':
                    $result =  (new FixerSocket())->getLatestExchangeRate($symbol);
                    break;
                case 'anohter_provider':
                    break;
                default:
                    $result = null;
                    break;
            }
            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getExchangeProvider()
    {
        return Configuration::config('currency_exchange_provider');
    }
}
