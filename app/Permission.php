<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function roles() {

        return $this->belongsToMany('App\Role', 'permission_role');

    }

    public function attachRole($role_id) {

        return $this->roles()->attach($role_id);

    }

}
