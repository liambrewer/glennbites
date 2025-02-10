<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('orders', fn () => true, [
    'guards' => ['employee']
]);
Broadcast::channel('orders.{id}', fn () => true, [
    'guards' => ['employee']
]);
