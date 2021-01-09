<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyThreshold extends Model
{
    protected $guarded = [];

    public const CONDITION = [
        1 => 'greater_than',
        2 => 'less_than',
        3 => 'equal_to'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
