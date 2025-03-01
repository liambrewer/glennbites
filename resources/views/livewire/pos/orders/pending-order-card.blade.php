<?php

use App\Events\OrderItemChanged;
use App\Models\Order;
use Livewire\Volt\Component;

new class extends Component {
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

        $orderItem->fulfilled = !$orderItem->fulfilled;
        $orderItem->save();

        OrderItemChanged::dispatch($orderItem);
    }
}; ?>

<x-pos.order-card :$order>
    <ul class="divide-y border-y">
        @foreach ($order->items as $item)
            <li wire:key="{{ $item->id }}">
                <button wire:click="toggleFulfilled({{ $item->id }})" wire:loading.attr="disabled"
                        wire:target="toggleFulfilled({{ $item->id }})"
                        class="flex px-2.5 py-3 gap-3 min-h-12 w-full text-left hover:bg-gray-50 duration-150">
                    <div class="shrink-0 text-gray-600">{{ $item->quantity }}x</div>
                    @if ($item->product->image_url)
                        <img class="size-6 border object-cover rounded" src="{{ $item->product->image_url }}"
                             alt="Product Image">
                    @endif
                    <div
                        class="grow text-gray-800 font-semibold @if ($item->fulfilled) line-through @endif">{{ $item->product->name }}</div>
                    <div class="shrink-0">
                        <div class="flex items-center justify-center size-6 text-green-500">
                            @if ($item->fulfilled)
                                <x-heroicon-s-check-circle wire:loading.remove
                                                           wire:target="toggleFulfilled({{ $item->id }})"/>
                            @else
                                <div wire:loading.remove wire:target="toggleFulfilled({{ $item->id }})"
                                     class="size-5 rounded-full border-2 border-dashed border-gray-300"></div>
                            @endif

                            <x-heroicon-s-arrow-path wire:loading wire:target="toggleFulfilled({{ $item->id }})"
                                                     class="text-gray-300 animate-spin"/>
                        </div>
                    </div>
                </button>
            </li>
        @endforeach
    </ul>

    <x-slot:actions>
        <x-pos.print-order-label-button class="w-full" :$order/>
        <div class="grid grid-cols-2 gap-2.5">
            <x-ui.button.danger
                wire:click="$dispatch('openModal', { component: 'pos.modals.cancel-order-modal', arguments: { order: {{ $order->id }} } })">
                <x-slot name="left">
                    <x-ui.button.icon icon="heroicon-m-x-mark"/>
                </x-slot>

                Cancel
            </x-ui.button.danger>
            <x-ui.button.success
                wire:click="$dispatch('openModal', { component: 'pos.modals.reserve-order-modal', arguments: { order: {{ $order->id }} } })"
                :disabled="! $order->can_reserve">
                <x-slot name="left">
                    <x-ui.button.icon icon="heroicon-m-check"/>
                </x-slot>

                Reserve
            </x-ui.button.success>
        </div>
    </x-slot:actions>
</x-pos.order-card>
