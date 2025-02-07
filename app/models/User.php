<?php

namespace App\Models;

use App\Core\Model;
use App\Models\Permission;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];

    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            'role_permissions',
            'role',
            'id',
            'role',
            'permission_id'
        );
    }

    public function hasPermission($permissionName)
    {
        return $this->permissions()
            ->where('name', $permissionName)
            ->exists();
    }

    public function getAllPermissions()
    {
        return $this->permissions()->get();
    }
}