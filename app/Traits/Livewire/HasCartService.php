<?php

namespace App\Traits\Livewire;

use App\Services\CartService;

trait HasCartService
{
    private CartService $cartService;

    public function bootHasCartService(CartService $cartService): void
    {
        $this->cartService = $cartService;
    }
}
