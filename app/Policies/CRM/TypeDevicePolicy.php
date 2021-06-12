<?php

namespace App\Policies\CRM;

use App\Models\User;
use App\Models\TypeDevice;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class TypeDevicePolicy
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
     * Determine whether the user can view any type devices.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-type_devices');
    }

    /**
     * Determine whether the user can view the type device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeDevice  $typeDevice
     * @return mixed
     */
    public function view(User $user, TypeDevice $typeDevice)
    {
        return $user->hasPermission('view-type_devices');
    }

    /**
     * Determine whether the user can create type devices.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-type_devices');
    }

    /**
     * Determine whether the user can update the type device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeDevice  $typeDevice
     * @return mixed
     */
    public function update(User $user, TypeDevice $typeDevice)
    {
        return $user->hasPermission('store-type_devices');
    }

    /**
     * Determine whether the user can delete the type device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeDevice  $typeDevice
     * @return mixed
     */
    public function delete(User $user, TypeDevice $typeDevice)
    {
        return $user->hasPermission('delete-type_devices');
    }

    /**
     * Determine whether the user can restore the type device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeDevice  $typeDevice
     * @return mixed
     */
    public function restore(User $user, TypeDevice $typeDevice)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the type device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeDevice  $typeDevice
     * @return mixed
     */
    public function forceDelete(User $user, TypeDevice $typeDevice)
    {
        //
    }
}
