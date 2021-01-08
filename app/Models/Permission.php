<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function roles()
    {

        return $this->belongsToMany('App\Models\Role', 'permission_role');
    }

    public function attachRole($roleId)
    {

        return $this->roles()->attach($roleId);
    }
}
