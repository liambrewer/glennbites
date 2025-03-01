<?php

use App\Models\Order;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.pos-layout')] class extends Component {
    const PENDING_COLLAPSED_KEY = 'current-orders.pending-collapsed';
    const RESERVED_COLLAPSED_KEY = 'current-orders.reserved-collapsed';

    /** @var Collection|Order[] */
    public Collection|array $pendingOrders;

    /** @var Collection|Order[] */
    public Collection|array $reservedOrders;

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
        $this->pendingCollapsed = !$this->pendingCollapsed;

        Session::put('current-orders.pending-collapsed', $this->pendingCollapsed);
    }

    public function toggleReservedCollapsed(): void
    {
        $this->reservedCollapsed = !$this->reservedCollapsed;

        Session::put('current-orders.reserved-collapsed', $this->reservedCollapsed);
    }
}; ?>

<div>
    <h1 class="text-lg font-semibold mb-5">Orders</h1>

    <div class="space-y-3">
        <div class="flex gap-2 items-center">
            <span class="text-xl font-bold text-gray-800">Pending Orders</span>

            <span class="text-lg text-gray-600">({{ $pendingOrders->count() }})</span>

            <div class="h-0.5 grow rounded-full bg-gray-400"></div>

            <button wire:click="togglePendingCollapsed" wire:loading.attr="disabled"
                    wire:target="togglePendingCollapsed"
                    class="flex items-center justify-center size-10 rounded-full hover:bg-gray-200 duration-150">
                @if ($pendingCollapsed)
                    <x-heroicon-o-chevron-up wire:loading.remove wire:target="togglePendingCollapsed"
                                             class="size-6 text-gray-600"/>
                @else
                    <x-heroicon-o-chevron-down wire:loading.remove wire:target="togglePendingCollapsed"
                                               class="size-6 text-gray-600"/>
                @endif

                <x-heroicon-o-arrow-path wire:loading wire:target="togglePendingCollapsed"
                                         class="size-6 text-gray-600 animate-spin"/>
            </button>
        </div>

        @unless ($pendingCollapsed)
            @if ($pendingOrders->isEmpty())
                <div
                    class="flex gap-3 items-center justify-center bg-white text-gray-800 border rounded-xl h-48 w-full">
                    <x-heroicon-o-clock class="size-8"/>

                    <span class="text-sm font-semibold">No pending orders.</span>
                </div>
            @else
                <ul class="grid grid-cols-3 gap-4">
                    @foreach ($pendingOrders as $order)
                        <livewire:pos.orders.pending-order-card wire:key="{{ $order->wire_key }}" :$order />
                    @endforeach
                </ul>
            @endempty
        @endunless

        <div class="flex gap-2 items-center">
            <span class="text-xl font-bold text-gray-800">Reserved Orders</span>

            <span class="text-lg text-gray-600">({{ $reservedOrders->count() }})</span>

            <div class="h-0.5 grow rounded-full bg-gray-400"></div>

            <button wire:click="toggleReservedCollapsed" wire:loading.attr="disabled"
                    wire:target="toggleReservedCollapsed"
                    class="flex items-center justify-center size-10 rounded-full hover:bg-gray-200 duration-150">
                @if ($reservedCollapsed)
                    <x-heroicon-o-chevron-up wire:loading.remove wire:target="toggleReservedCollapsed"
                                             class="size-6 text-gray-600"/>
                @else
                    <x-heroicon-o-chevron-down wire:loading.remove wire:target="toggleReservedCollapsed"
                                               class="size-6 text-gray-600"/>
                @endif

                <x-heroicon-o-arrow-path wire:loading wire:target="toggleReservedCollapsed"
                                         class="size-6 text-gray-600 animate-spin"/>
            </button>
        </div>

        @unless ($reservedCollapsed)
            @if ($reservedOrders->isEmpty())
                <div
                    class="flex gap-3 items-center justify-center bg-white text-gray-800 border rounded-xl h-48 w-full">
                    <x-heroicon-o-wallet class="size-8"/>

                    <span class="text-sm font-semibold">No reserved orders.</span>
                </div>
            @else
                <ul class="grid grid-cols-3 gap-4 place-items">
                    @foreach ($reservedOrders as $order)
                        <livewire:pos.orders.reserved-order-card wire:key="{{ $order->wire_key }}" :$order />
                    @endforeach
                </ul>
            @endempty
        @endunless
    </div>
</div>
