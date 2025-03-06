<?php

namespace App\Services;

use App\Exceptions\ProductNotFoundException;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth('web')->user()->id]);
    }

    public function addToCart(int $productId, int $quantity): void
    {
        $cart = $this->getCart();

        $item = $cart->items()->firstOrNew(['product_id' => $productId]);
        $item->quantity += $quantity;
        $item->save();
    }

    public function removeFromCart(int $productId, int $quantity): void
    {
        $cart = $this->getCart();

        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            $item->quantity = max(1, $item->quantity - $quantity);
            $item->save();
        }
    }

    public function deleteFromCart(int $productId): void
    {
        $cart = $this->getCart();

        $item = $cart->items()->where('product_id', $productId)->first();

        if ($item) {
            $item->delete();
        }
    }

    public function clearCart(): void
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }
}
