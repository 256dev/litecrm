<?php

namespace App\Policies\CRM;

use App\Models\Condition;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class ConditionPolicy
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
     * Determine whether the user can view any conditions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-conditions');
    }

    /**
     * Determine whether the user can view the condition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Condition  $condition
     * @return mixed
     */
    public function view(User $user, Condition $condition)
    {
        return $user->hasPermission('view-conditions');
    }

    /**
     * Determine whether the user can create conditions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-condition');
    }

    /**
     * Determine whether the user can update the condition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Condition  $condition
     * @return mixed
     */
    public function update(User $user, Condition $condition)
    {
        return $user->hasPermission('store-condition');
    }

    /**
     * Determine whether the user can delete the condition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Condition  $condition
     * @return mixed
     */
    public function delete(User $user, Condition $condition)
    {
        return $user->hasPermission('delete-condition');
    }

    /**
     * Determine whether the user can restore the condition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Condition  $condition
     * @return mixed
     */
    public function restore(User $user, Condition $condition)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the condition.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Condition  $condition
     * @return mixed
     */
    public function forceDelete(User $user, Condition $condition)
    {
        //
    }
}
