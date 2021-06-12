<?php

namespace App\Policies\CRM;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Providers\AuthServiceProvider;

class OrderPolicy
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
     * Determine whether the user can view any orders.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-orders');
    }

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        if ($user->hasPermission('view-orders') 
            || $order->customer_id === $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('store-order');
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        if ($user->hasPermission('store-order') 
            || $order->customer_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        if ($user->hasPermission('delete-order') 
            || $order->customer_id === $user->id) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        //
    }
}
