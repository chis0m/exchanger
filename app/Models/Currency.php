<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $guarded = [];

    public function currencyThreshold()
    {
        return $this->hasMany('App\Models\CurrencyThreshold', 'target_currency_id');
    }

    public function user()
    {
        return $this->hasMany('App\User', 'base_currency_id');
    }
}
