<?php

namespace App\Models;

use App\Core\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['name', 'description'];

    public function roles()
    {
        return $this->belongsToMany(
            'App\Models\Role',
            'role_permissions',
            'permission_id',
            'role_id'
        );
    }
}
