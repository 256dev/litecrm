<?php

namespace App\Policies\CRM;

use App\Models\AppSettings;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class SettingsPolicy
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
     * Determine whether the user can view any app settings.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-settings');
    }

    /**
     * Determine whether the user can view the app settings.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppSettings  $appSettings
     * @return mixed
     */
    public function view(User $user, AppSettings $appSettings)
    {
        return $user->hasPermission('view-settings');
    }

    /**
     * Determine whether the user can create app settings.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-settings');
    }

    /**
     * Determine whether the user can update the app settings.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppSettings  $appSettings
     * @return mixed
     */
    public function update(User $user, AppSettings $appSettings)
    {
        return $user->hasPermission('store-settings');
    }

    /**
     * Determine whether the user can delete the app settings.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppSettings  $appSettings
     * @return mixed
     */
    public function delete(User $user, AppSettings $appSettings)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the app settings.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppSettings  $appSettings
     * @return mixed
     */
    public function restore(User $user, AppSettings $appSettings)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the app settings.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AppSettings  $appSettings
     * @return mixed
     */
    public function forceDelete(User $user, AppSettings $appSettings)
    {
        //
    }
}
