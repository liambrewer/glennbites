<?php

namespace App\Services;

use App\Exceptions\ProductNotFoundException;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    const CART_SESSION_KEY = 'cart';

    public function getCart(): array
    {
        return Session::get(self::CART_SESSION_KEY, []);
    }

    public function saveCart(array $cart): void
    {
        Session::put(self::CART_SESSION_KEY, $cart);
    }

    public function clearCart(): void
    {
        Session::forget(self::CART_SESSION_KEY);
    }

    /**
     * Adds an item to the cart.
     *
     * @throws ProductNotFoundException
     */
    public function addToCart(int $productId, int $quantity): void
    {
        $product = Product::find($productId);
        if (! $product) {
            throw new ProductNotFoundException;
        }

        $cart = $this->getCart();

        $existingItemKey = array_search($productId, array_column($cart, 'product_id'));

        // TODO: WE NEED SAFER VALUES LIKE REMOVEFROMCART
        if ($existingItemKey !== false) {
            $cart[$existingItemKey]['quantity'] += $quantity;
        } else {
            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        }

        $this->saveCart($cart);
    }

    public function removeFromCart(int $productId, int $quantity): void
    {
        $cart = $this->getCart();

        $existingItemKey = array_search($productId, array_column($cart, 'product_id'));

        if ($existingItemKey !== false) {
            // we need a safe-ish quantity!!!
            $cart[$existingItemKey]['quantity'] = max(1, $cart[$existingItemKey]['quantity'] - $quantity);
        }

        $this->saveCart($cart);
    }

    public function deleteFromCart(int $productId): void
    {
        $cart = $this->getCart();

        $newCart = array_filter($cart, fn ($item) => $item['product_id'] != $productId);

        $this->saveCart($newCart);
    }

    // TODO: This is a janko way of doing things.
    public function buildForFrontend(): array
    {
        $cart = $this->getCart();

        // It feels very wrong to pass these to the array_map callback...
        $total = 0;
        $valid = true;

        /*
         * TODO: There is probably a waaaaaaaay better way to do this.... use(&total, &valid)
         */
        $cartItems = array_map(function ($item) use (&$total, &$valid) {
            $product = Product::find($item['product_id']);
            $quantity = $item['quantity'];

            $cartItem = [
                'product' => ProductResource::make($product),
                'quantity' => $quantity,
                'price' => $product->price * $quantity,
            ];

            $total += $cartItem['price'];

            try {
                $product->ensureValidQuantity($quantity);
            } catch (\Exception $e) {
                $valid = false;
                $cartItem['error'] = $e->getMessage();
            }

            return $cartItem;
        }, $cart);

        return [
            'items' => $cartItems,
            'total' => $total,
            'valid' => $valid,
        ];
    }
}
