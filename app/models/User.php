<?php

namespace App\Models;

use App\Core\Model;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\Role;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['username', 'email', 'password', 'role'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role', 'name');
    }

    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            RolePermission::class,
            'role',
            'id',
            'role',
            'permission_id'
        );
    }

    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    public function getAllPermissions()
    {
        return $this->permissions()->get();
    }
}