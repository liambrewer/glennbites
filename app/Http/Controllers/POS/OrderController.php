<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items')->get();

        return response()->json(OrderResource::collection($orders));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items');

        return response()->json(OrderResource::make($order));
    }
}
