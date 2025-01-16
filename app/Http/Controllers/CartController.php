<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddRequest;
use App\Http\Requests\CartDeleteRequest;
use App\Http\Requests\CartRemoveRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }

    public function index()
    {
        return Inertia::render('Cart/Index');
    }

    public function add(CartAddRequest $request)
    {
        $validated = $request->validated();

        $this->cartService->addToCart($validated['product_id'], $validated['quantity']);

        return back();
    }

    public function remove(CartRemoveRequest $request)
    {
        $validated = $request->validated();

        $this->cartService->removeFromCart($validated['product_id'], $validated['quantity']);

        return back();
    }

    public function delete(CartDeleteRequest $request)
    {
        $validated = $request->validated();

        $this->cartService->deleteFromCart($validated['product_id']);

        return back();
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return back();
    }
}
