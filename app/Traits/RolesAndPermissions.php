<?php
namespace App\Traits;

use App\Models\Role;

trait RolesAndPermissions
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->role->permissions;
    }

    public function hasRole($role)
    {
        return $this->role->name === $role
            ? true
            : false;
    }

    public function hasPermission($permission)
    {
        foreach ($this->permissions() as $item) {
            if ($item->slug === $permission) {
                return true;
            }
        }

        return false;
    }
}