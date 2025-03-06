<?php

namespace App\Http\Controllers\Storefront;

use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartAddRequest;
use App\Http\Requests\CartDeleteRequest;
use App\Http\Requests\CartRemoveRequest;
use App\Services\CartService;
use Inertia\Inertia;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index()
    {
        $cartDetails = $this->cartService->buildForFrontend();

        return Inertia::render('cart', $cartDetails);
    }

    public function add(CartAddRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->cartService->addToCart($validated['product_id'], $validated['quantity']);

            return back();
        } catch (ProductNotFoundException $e) {
            return back()->with('message', 'Product not found.');
        }
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
