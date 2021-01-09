<?php

namespace App\Services;

use App\Models\CurrencyThreshold;
use Exception;
use App\User;

class CurrencyService
{
    public function create($request)
    {
        $user = $request->user();
        if (!$user->base_currency) {
            throw new Exception('Please set your base currency', 422);
        }
        if ($user->base_currency == $request['target_currency']) {
            throw new Exception("Base currency can't be the same with target currency", 422);
        }
        $data = $user->threshold()->create($request->validated());
        return $data;
    }

    public function update($id, $request)
    {
        $user = $request->user();
        $threshold = $this->getThreshold($id);
        if ($user['base_currency'] == $request['target_currency']) {
            throw new Exception("You've already set this currency as your Base currency", 422);
        }
        $targeCurrency = $request['target_currency'] ? $request['target_currency'] : $threshold['target_currency'];
        $currencyName = $request['currency_name'] ? $request['currency_name'] : $threshold['currency_name'];
        $thresholdNumber = $request['threshold_number'] ? $request['threshold_number'] : $threshold['threshold_number'];
        $condition = $request['condition'] ? $request['condition'] : $threshold['condition'];

        $data = CurrencyThreshold::updateOrCreate(
            ['id' => $id],
            [
                'target_currency' => $targeCurrency,
                'currency_name' => $currencyName,
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
