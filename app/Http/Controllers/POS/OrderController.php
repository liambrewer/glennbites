<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $order->load('user', 'items');

        return response()->json(OrderResource::make($order));
    }
}
