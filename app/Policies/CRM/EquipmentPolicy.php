<?php

namespace App\Policies\CRM;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class EquipmentPolicy
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
     * Determine whether the user can view any equipment.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-equipments');
    }

    /**
     * Determine whether the user can view the equipment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Equipment  $equipment
     * @return mixed
     */
    public function view(User $user, Equipment $equipment)
    {
        return $user->hasPermission('view-equipments');
    }

    /**
     * Determine whether the user can create equipment.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-equipment');
    }

    /**
     * Determine whether the user can update the equipment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Equipment  $equipment
     * @return mixed
     */
    public function update(User $user, Equipment $equipment)
    {
        return $user->hasPermission('store-equipment');
    }

    /**
     * Determine whether the user can delete the equipment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Equipment  $equipment
     * @return mixed
     */
    public function delete(User $user, Equipment $equipment)
    {
        return $user->hasPermission('delete-equipment');
    }

    /**
     * Determine whether the user can restore the equipment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Equipment  $equipment
     * @return mixed
     */
    public function restore(User $user, Equipment $equipment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the equipment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Equipment  $equipment
     * @return mixed
     */
    public function forceDelete(User $user, Equipment $equipment)
    {
        //
    }
}
