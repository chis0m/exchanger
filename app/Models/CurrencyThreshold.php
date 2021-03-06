<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyThreshold extends Model
{
    protected $guarded = [];

    protected $table = 'currency_thresholds';

    public const CONDITION = [
        1 => 'greater_than',
        2 => 'less_than',
        3 => 'equal_to'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'target_currency_id');
    }
}
