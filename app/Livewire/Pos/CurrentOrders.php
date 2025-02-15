<?php

namespace App\Livewire\Pos;

use App\Events\OrderItemChanged;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Component;

class CurrentOrders extends Component
{
    const PENDING_COLLAPSED_KEY = 'current-orders.pending-collapsed';
    const RESERVED_COLLAPSED_KEY = 'current-orders.reserved-collapsed';

    /** @var Order[] */
    public $pendingOrders = [];

    /** @var Order[] */
    public $reservedOrders = [];

    public bool $pendingCollapsed;
    public bool $reservedCollapsed;

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

        $this->pendingCollapsed = Session::get($this::PENDING_COLLAPSED_KEY, false);
        $this->reservedCollapsed = Session::get($this::RESERVED_COLLAPSED_KEY, false);
    }

    public function fetchOrders(): void
    {
        $this->pendingOrders = Order::pending()->with('user', 'items', 'items.product')->get();
        $this->reservedOrders = Order::reserved()->with('user', 'items', 'items.product')->get();
    }

    public function togglePendingCollapsed(): void
    {
        $this->pendingCollapsed = ! $this->pendingCollapsed;

        Session::put('current-orders.pending-collapsed', $this->pendingCollapsed);
    }

    public function toggleReservedCollapsed(): void
    {
        $this->reservedCollapsed = ! $this->reservedCollapsed;

        Session::put('current-orders.reserved-collapsed', $this->reservedCollapsed);
    }

    public function render(): View
    {
        $this->authorizeForUser(auth('employee')->user(), 'viewAny', Order::class);

        return view('livewire.pos.current-orders');
    }
}
