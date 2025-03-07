<?php

namespace App\Policies;

use App\Contracts\Authorizable;
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

    public function view(Authorizable $authorizable, Order $order): bool
    {
        return $authorizable->isEmployee() || $order->user->id === $authorizable->getId();
    }

    public function viewAny(Authorizable $authorizable): bool
    {
        return $authorizable->isEmployee();
    }

    public function create(Authorizable $authorizable): bool
    {
        return $authorizable->isEmployee();
    }

    public function update(Authorizable $authorizable): bool
    {
        return $authorizable->isEmployee();
    }

    public function reserve(Authorizable $authorizable): bool
    {
        return $authorizable->isEmployee();
    }

    public function short(Authorizable $authorizable): bool
    {
        return $authorizable->isEmployee();
    }

    public function cancel(Authorizable $authorizable, Order $order): bool
    {
        return $authorizable->isEmployee() || $order->user->id === $authorizable->getId();
    }

    public function complete(Authorizable $authorizable): bool
    {
        return $authorizable->isEmployee();
    }
}
