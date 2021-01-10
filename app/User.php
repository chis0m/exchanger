<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\User as UserTrait;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use UserTrait;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_no', 'country', 'base_currency_id', 'first_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function thresholds()
    {
        return $this->hasMany('App\Models\CurrencyThreshold');
    }

    public function baseCurrency()
    {
        return $this->belongsTo('App\Models\Currency', 'base_currency_id');
    }

    public function scopeHavingThreshold($query)
    {
        return $query->whereHas('thresholds')->get();
    }
}
