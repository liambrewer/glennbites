<?php

use App\Models\Order;
use Livewire\Volt\Component;

new class extends Component {
    public Order $order;
}; ?>

<x-pos.order-card :$order>
    <ul class="divide-y border-y">
        @foreach ($order->items as $item)
            <li wire:key="{{ $item->id }}">
                <div class="flex px-2.5 py-3 gap-3 min-h-12 w-full">
                    <div class="shrink-0 text-gray-600">{{ $item->quantity }}x</div>
                    @if ($item->product->image_url)
                        <img class="size-6 border object-cover rounded" src="{{ $item->product->image_url }}"
                             alt="Product Image">
                    @endif
                    <div class="grow text-gray-800 font-semibold">{{ $item->product->name }}</div>
                    <div class="shrink-0">
                        <div class="flex items-center justify-center size-6 text-green-500">
                            <x-heroicon-s-check/>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <x-slot:actions>
        <x-ui.button.danger
            wire:click="$dispatch('openModal', { component: 'pos.modals.cancel-order-modal', arguments: { order: {{ $order->id }} } })"
        >
            <x-slot name="left">
                <x-ui.button.icon icon="heroicon-m-x-mark"/>
            </x-slot>

            Cancel
        </x-ui.button.danger>

        <x-ui.button.success
            wire:click="$dispatch('openModal', { component: 'pos.modals.complete-order-modal', arguments: { order: {{ $order->id }} } })"
        >
            <x-slot name="left">
                <x-ui.button.icon icon="heroicon-m-check"/>
            </x-slot>

            Complete
        </x-ui.button.success>
    </x-slot:actions>
</x-pos.order-card>
