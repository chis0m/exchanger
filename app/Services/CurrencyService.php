<?php

namespace App\Services;

use App\Services\ThirdParty\Exchange\Adapter as ExchangeAdapter;
use App\Models\CurrencyThreshold;
use App\Models\Currency;
use Exception;
use App\User;

class CurrencyService
{

    public function populateCurrencyTable()
    {
        $currenciesFromRemote = (new ExchangeAdapter())->getCurrencies();
        foreach ($currenciesFromRemote as $key => $value) {
            Currency::updateOrCreate(
                ['symbol' => $key],
                ['title' => $value]
            );
        }
    }


    public function create($request)
    {
        $user = $request->user();
        if (!$user['base_currency_id']) {
            throw new Exception('Please set your base currency', 422);
        }
        if ($user['base_currency_id'] == $request['target_currency_id']) {
            throw new Exception("Base currency can't be the same with target currency", 422);
        }
        $data = $user->threshold()->create($request->validated());
        return $data;
    }

    public function update($id, $request)
    {
        $user = $request->user();
        $threshold = $this->getThreshold($id);
        if ($user['base_currency_id'] == $request['target_currency_id']) {
            throw new Exception("You've already set this currency as your Base currency", 422);
        }
        $targeCurrencyId = $request['target_currency_id'] ? $request['target_currency_id'] : $threshold['target_currency_id'];
        $thresholdNumber = $request['threshold_number'] ? $request['threshold_number'] : $threshold['threshold_number'];
        $condition = $request['condition'] ? $request['condition'] : $threshold['condition'];

        $data = CurrencyThreshold::updateOrCreate(
            ['id' => $id],
            [
                'target_currency_id' => $targeCurrencyId,
                'threshold_number' => $thresholdNumber,
                'condition' => $condition,
            ]
        );
        return $data;
    }

    public function getThreshold($id)
    {
        return CurrencyThreshold::find($id);
    }
}
