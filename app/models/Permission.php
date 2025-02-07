<?php

namespace App\Models;

use App\Core\Model;
use App\Models\Role;
use App\Models\RolePermission;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['name', 'description'];

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions',
            'permission_id',
            'role_id'
        );
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
