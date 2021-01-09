<?php

namespace App\Services\ThirdParty\Exchange;

use App\Models\Configuration;
use Exception;

class Adapter
{

    public function getCurrencies()
    {
        try {
            $provider = $this->getExchangeProvider();
            $result = null;
            switch ($provider) {
                case 'fixer':
                    $result =  (new FixerSocket())->getCurrencySymbols();
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
        return Configuration::whereSlug('currency_exchange_provider')->first()['value'];
    }
}
