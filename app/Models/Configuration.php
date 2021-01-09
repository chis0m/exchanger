<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $guarded = [];

    public const RANGE = [
        1 => 'one',
        2 => 'any'
    ];
}
