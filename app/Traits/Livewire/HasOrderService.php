<?php

namespace App\Traits\Livewire;

use App\Services\OrderService;

trait HasOrderService
{
    private OrderService $orderService;

    public function bootHasOrderService(OrderService $orderService): void
    {
        $this->orderService = $orderService;
    }
}
