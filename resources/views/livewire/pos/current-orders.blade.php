@php
/* @var App\Models\Order[] $pendingOrders */
/* @var App\Models\Order[] $reservedOrders */

use App\Enums\OrderStatus;
@endphp

<div class="space-y-3">
    <div class="flex gap-2 items-center">
        <span class="text-xl font-bold text-gray-800">Pending Orders</span>

        <span class="text-lg text-gray-600">({{ $pendingOrders->count() }})</span>

        <div class="h-0.5 grow rounded-full bg-gray-400"></div>

        <button wire:click="togglePendingCollapsed" wire:loading.attr="disabled" wire:target="togglePendingCollapsed" class="flex items-center justify-center size-10 rounded-full hover:bg-gray-200 duration-150">
            @if ($pendingCollapsed)
                <x-heroicon-o-chevron-up wire:loading.remove wire:target="togglePendingCollapsed" class="size-6 text-gray-600" />
            @else
                <x-heroicon-o-chevron-down wire:loading.remove wire:target="togglePendingCollapsed" class="size-6 text-gray-600" />
            @endif

            <x-heroicon-o-arrow-path wire:loading wire:target="togglePendingCollapsed" class="size-6 text-gray-600 animate-spin" />
        </button>
    </div>

    @unless ($pendingCollapsed)
        @if ($pendingOrders->isEmpty())
            <div class="flex gap-3 items-center justify-center bg-white text-gray-800 border rounded-xl h-48 w-full">
                <x-heroicon-o-clock class="size-8" />

                <span class="text-sm font-semibold">No pending orders.</span>
            </div>
        @else
            <ul class="grid grid-cols-3 gap-4">
                @foreach ($pendingOrders as $order)
                    <livewire:pos.pending-order-card wire:key="{{ $order->wire_key }}" :$order />
                @endforeach
            </ul>
        @endempty
    @endunless

    <div class="flex gap-2 items-center">
        <span class="text-xl font-bold text-gray-800">Reserved Orders</span>

        <span class="text-lg text-gray-600">({{ $reservedOrders->count() }})</span>

        <div class="h-0.5 grow rounded-full bg-gray-400"></div>

        <button wire:click="toggleReservedCollapsed" wire:loading.attr="disabled" wire:target="toggleReservedCollapsed" class="flex items-center justify-center size-10 rounded-full hover:bg-gray-200 duration-150">
            @if ($reservedCollapsed)
                <x-heroicon-o-chevron-up wire:loading.remove wire:target="toggleReservedCollapsed" class="size-6 text-gray-600" />
            @else
                <x-heroicon-o-chevron-down wire:loading.remove wire:target="toggleReservedCollapsed" class="size-6 text-gray-600" />
            @endif

            <x-heroicon-o-arrow-path wire:loading wire:target="toggleReservedCollapsed" class="size-6 text-gray-600 animate-spin" />
        </button>
    </div>

    @unless ($reservedCollapsed)
        @if ($reservedOrders->isEmpty())
            <div class="flex gap-3 items-center justify-center bg-white text-gray-800 border rounded-xl h-48 w-full">
                <x-heroicon-o-wallet class="size-8" />

                <span class="text-sm font-semibold">No reserved orders.</span>
            </div>
        @else
            <ul class="grid grid-cols-3 gap-4 place-items">
                @foreach ($reservedOrders as $order)
                    <livewire:pos.reserved-order-card wire:key="{{ $order->wire_key }}" :$order />
                @endforeach
            </ul>
        @endempty
    @endunless
</div>
