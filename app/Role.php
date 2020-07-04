<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function permissions() {

        return $this->belongsToMany('App\Permission', 'permission_role');

    }

    public function attachPermission($permission_id) {

        return $this->permissions()->attach($permission_id);

    }


}
