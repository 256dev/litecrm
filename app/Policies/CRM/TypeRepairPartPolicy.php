<?php

namespace App\Policies\CRM;

use App\Models\User;
use App\Models\TypeRepairPart;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class TypeRepairPartPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if (
            $user->role->slug === AuthServiceProvider::ROLE_ADMIN
            || $user->role->slug === AuthServiceProvider::ROLE_DIRECTOR
        ) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any type repair parts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-repair_parts');
    }

    /**
     * Determine whether the user can view the type repair part.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeRepairPart  $typeRepairPart
     * @return mixed
     */
    public function view(User $user, TypeRepairPart $typeRepairPart)
    {
        return $user->hasPermission('view-repair_parts');
    }

    /**
     * Determine whether the user can create type repair parts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-repair_part');
    }

    /**
     * Determine whether the user can update the type repair part.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeRepairPart  $typeRepairPart
     * @return mixed
     */
    public function update(User $user, TypeRepairPart $typeRepairPart)
    {
        return $user->hasPermission('store-repair_part');
    }

    /**
     * Determine whether the user can delete the type repair part.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeRepairPart  $typeRepairPart
     * @return mixed
     */
    public function delete(User $user, TypeRepairPart $typeRepairPart)
    {
        return $user->hasPermission('delete-repair_part');
    }

    /**
     * Determine whether the user can restore the type repair part.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeRepairPart  $typeRepairPart
     * @return mixed
     */
    public function restore(User $user, TypeRepairPart $typeRepairPart)
    {
        // 
    }

    /**
     * Determine whether the user can permanently delete the type repair part.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeRepairPart  $typeRepairPart
     * @return mixed
     */
    public function forceDelete(User $user, TypeRepairPart $typeRepairPart)
    {
        // 
    }
}
