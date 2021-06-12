<?php

namespace App\Policies\CRM;

use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class ManufacturerPolicy
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
     * Determine whether the user can view any manufacturers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-manufacturers');
    }

    /**
     * Determine whether the user can view the manufacturer.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Manufacturer  $manufacturer
     * @return mixed
     */
    public function view(User $user, Manufacturer $manufacturer)
    {
        return $user->hasPermission('view-manufacturers');
    }

    /**
     * Determine whether the user can create manufacturers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-manufacturer');
    }

    /**
     * Determine whether the user can update the manufacturer.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Manufacturer  $manufacturer
     * @return mixed
     */
    public function update(User $user, Manufacturer $manufacturer)
    {
        return $user->hasPermission('store-manufacturer');
    }

    /**
     * Determine whether the user can delete the manufacturer.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Manufacturer  $manufacturer
     * @return mixed
     */
    public function delete(User $user, Manufacturer $manufacturer)
    {
        return $user->hasPermission('delete-manufacturer');
    }

    /**
     * Determine whether the user can restore the manufacturer.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Manufacturer  $manufacturer
     * @return mixed
     */
    public function restore(User $user, Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the manufacturer.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Manufacturer  $manufacturer
     * @return mixed
     */
    public function forceDelete(User $user, Manufacturer $manufacturer)
    {
        //
    }
}
