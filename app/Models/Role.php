<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function permissions()
    {

        return $this->belongsToMany('App\Models\Permission', 'permission_role');
    }

    public function attachPermission($permissionId)
    {

        return $this->permissions()->attach($permissionId);
    }
}
