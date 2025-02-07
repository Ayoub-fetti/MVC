<?php

namespace App\Models;

use App\Core\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        );
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role', 'name');
    }
}
