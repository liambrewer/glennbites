<?php

namespace App\Livewire\Pos;

use App\Models\Order;
use App\Services\OrderService;
use LivewireUI\Modal\ModalComponent;

class ReserveOrderModal extends ModalComponent
{
    private OrderService $orderService;

    public Order $order;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function reserve()
    {
        $this->orderService->reserveOrder($this->order->id, auth('employee')->user());
    }

    public function render()
    {
        return view('livewire.pos.reserve-order-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }
}
