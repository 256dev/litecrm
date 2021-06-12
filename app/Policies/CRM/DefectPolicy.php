<?php

namespace App\Policies\CRM;

use App\Models\Defect;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class DefectPolicy
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
     * Determine whether the user can view any defects.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-defects');
    }

    /**
     * Determine whether the user can view the defect.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Defect  $defect
     * @return mixed
     */
    public function view(User $user, Defect $defect)
    {
        return $user->hasPermission('view-defects');
    }

    /**
     * Determine whether the user can create defects.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-defect');
    }

    /**
     * Determine whether the user can update the defect.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Defect  $defect
     * @return mixed
     */
    public function update(User $user, Defect $defect)
    {
        return $user->hasPermission('store-defect');
    }

    /**
     * Determine whether the user can delete the defect.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Defect  $defect
     * @return mixed
     */
    public function delete(User $user, Defect $defect)
    {
        return $user->hasPermission('delete-defect');
    }

    /**
     * Determine whether the user can restore the defect.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Defect  $defect
     * @return mixed
     */
    public function restore(User $user, Defect $defect)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the defect.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Defect  $defect
     * @return mixed
     */
    public function forceDelete(User $user, Defect $defect)
    {
        //
    }
}
