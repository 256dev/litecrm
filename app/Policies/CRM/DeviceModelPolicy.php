<?php

namespace App\Policies\CRM;

use App\Models\DeviceModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class DeviceModelPolicy
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
     * Determine whether the user can view any devices.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-devices');
    }

    /**
     * Determine whether the user can view the device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\DeviceModel  $device
     * @return mixed
     */
    public function view(User $user, DeviceModel $device)
    {
        return $user->hasPermission('view-devices');
    }

    /**
     * Determine whether the user can create devices.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-device');
    }

    /**
     * Determine whether the user can update the device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\DeviceModel  $device
     * @return mixed
     */
    public function update(User $user, DeviceModel $device)
    {
        return $user->hasPermission('store-device');
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\DeviceModel  $device
     * @return mixed
     */
    public function delete(User $user, DeviceModel $device)
    {
        return $user->hasPermission('delete-device');
    }

    /**
     * Determine whether the user can restore the device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\DeviceModel  $device
     * @return mixed
     */
    public function restore(User $user, DeviceModel $device)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the device.
     *
     * @param  \App\Models\User  $user
     * @param  \App\DeviceModels  $device
     * @return mixed
     */
    public function forceDelete(User $user, DeviceModel $device)
    {
        //
    }
}
