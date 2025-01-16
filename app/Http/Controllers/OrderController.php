<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function create(CreateOrderRequest $request)
    {
        $validated = $request->validated();

        try {
            $order = $this->orderService->createOrder(User::find(1), $validated['items']);
        } catch (\Exception $e) {
            return back()->with('message', $e->getMessage());
        }

        return response()->json($order);
    }
}
