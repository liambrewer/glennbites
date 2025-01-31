<?php

namespace App\Livewire\Pos;

use App\Models\Order;
use App\Services\OrderService;
use LivewireUI\Modal\ModalComponent;

class CancelOrderModal extends ModalComponent
{
    private OrderService $orderService;

    public Order $order;

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function short()
    {
        $this->orderService->shortOrder($this->order->id, auth('employee')->user());
    }

    public function cancel()
    {
        $this->orderService->cancelOrder($this->order->id, auth('employee')->user());
    }

    public function render()
    {
        return view('livewire.pos.cancel-order-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }
}
