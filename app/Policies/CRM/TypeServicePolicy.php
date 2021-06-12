<?php

namespace App\Policies\CRM;

use App\Models\User;
use App\Models\TypeService;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class TypeServicePolicy
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
     * Determine whether the user can view any services.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-services');
    }

    /**
     * Determine whether the user can view the service.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeService  $service
     * @return mixed
     */
    public function view(User $user, TypeService $service)
    {
        return $user->hasPermission('view-services');
    }

    /**
     * Determine whether the user can create services.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-service');
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeService  $service
     * @return mixed
     */
    public function update(User $user, TypeService $service)
    {
        return $user->hasPermission('store-service');
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeService  $service
     * @return mixed
     */
    public function delete(User $user, TypeService $service)
    {
        return $user->hasPermission('delete-service');
    }

    /**
     * Determine whether the user can restore the service.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeService  $service
     * @return mixed
     */
    public function restore(User $user, TypeService $service)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the service.
     *
     * @param  \App\Models\User  $user
     * @param  \App\TypeService  $service
     * @return mixed
     */
    public function forceDelete(User $user, TypeService $service)
    {
        //
    }
}
