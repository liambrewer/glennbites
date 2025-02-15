<?php

namespace App\Livewire\Pos;

use App\Events\OrderItemChanged;
use App\Models\Order;
use Illuminate\View\View;
use Livewire\Component;

class PendingOrderCard extends Component
{
    public Order $order;

    public function getListeners(): array
    {
        return [
            "echo-private:orders.{$this->order->id},OrderCreated" => '$refresh',
            "echo-private:orders.{$this->order->id},OrderReserved" => '$refresh',
            "echo-private:orders.{$this->order->id},OrderCompleted" => '$refresh',
            "echo-private:orders.{$this->order->id},OrderCanceled" => '$refresh',
            "echo-private:orders.{$this->order->id},OrderShorted" => '$refresh',
            "echo-private:orders.{$this->order->id},OrderItemChanged" => '$refresh'
        ];
    }

    public function toggleFulfilled(int $orderItemId): void
    {
        $orderItem = $this->order->items()->findOrFail($orderItemId);

        $orderItem->fulfilled = ! $orderItem->fulfilled;
        $orderItem->save();

        OrderItemChanged::dispatch($orderItem);
    }

    public function render(): View
    {
        $this->authorizeForUser(auth('employee')->user(), 'view', $this->order);

        return view('livewire.pos.pending-order-card');
    }
}
