<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User|Employee $actor, Order $order): bool
    {
        return $actor instanceof Employee || $order->user()->is($actor);
    }

    public function viewAny(User|Employee $actor): bool
    {
        return $actor instanceof Employee;
    }

    public function create(User|Employee $actor): bool
    {
        return $actor instanceof User;
    }

    public function update(User|Employee $actor): bool
    {
        return $actor instanceof Employee;
    }

    public function reserve(User|Employee $actor): bool
    {
        return $actor instanceof Employee;
    }

    public function short(User|Employee $actor): bool
    {
        return $actor instanceof Employee;
    }

    public function cancel(User|Employee $actor, Order $order): bool
    {
        return $actor instanceof Employee || $order->user()->is($actor);
    }

    public function complete(User|Employee $actor): bool
    {
        return $actor instanceof Employee;
    }
}
