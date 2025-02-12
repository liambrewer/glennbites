<?php

namespace App\Livewire\Pos;

use App\Events\OrderItemChanged;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\View\View;
use Livewire\Component;

class CurrentOrders extends Component
{
    public $orders;

    public function getListeners(): array
    {
        return [
            "echo-private:orders,OrderCreated" => "fetchOrders",
            "echo-private:orders,OrderReserved" => "fetchOrders",
            "echo-private:orders,OrderCompleted" => "fetchOrders",
            "echo-private:orders,OrderCanceled" => "fetchOrders",
            "echo-private:orders,OrderShorted" => "fetchOrders",
            "echo-private:orders,OrderItemChanged" => "fetchOrders",
        ];
    }

    public function mount(): void
    {
        $this->fetchOrders();
    }

    public function fetchOrders(): void
    {
        $this->orders = Order::current()->with('user', 'items', 'items.product')->get();
    }

    public function markOrderItemAsFulfilled(int $orderItemId): void
    {
        $orderItem = OrderItem::findOrFail($orderItemId);

        $orderItem->load('order');

        $this->authorizeForUser(auth('employee')->user(), 'update', $orderItem->order);

        $orderItem->fulfilled = ! $orderItem->fulfilled;
        $orderItem->save();

        OrderItemChanged::dispatch($orderItem);
    }

    public function render(): View
    {
        $this->authorizeForUser(auth('employee')->user(), 'viewAny', Order::class);

        return view('livewire.pos.current-orders');
    }
}
