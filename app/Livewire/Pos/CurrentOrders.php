<?php

namespace App\Livewire\Pos;

use App\Models\Order;
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

    public function render(): View
    {
        $this->authorizeForUser(auth('employee')->user(), 'viewAny', Order::class);

        return view('livewire.pos.current-orders');
    }
}
