@php
/* @var App\Models\Order[] $orders */

use App\Enums\OrderStatus;
@endphp

<div>
    @if ($orders->isEmpty())
        <div class="flex gap-3 items-center justify-center bg-white text-gray-800 border rounded-xl h-48 w-full">
            <x-heroicon-o-arrow-trending-down class="size-8" />

            <span class="text-sm font-semibold">No current orders.</span>
        </div>
    @else
        <ul class="grid grid-cols-3 gap-4">
            @foreach ($orders as $order)
                <li wire:key="{{ $order->id }}" class="flex flex-col h-fit">
                    @php
                        $bannerStyle = match ($order->status) {
                            OrderStatus::PENDING => ['icon' => 'heroicon-m-clock', 'classes' => 'bg-yellow-500'],
                            OrderStatus::RESERVED => ['icon' => 'heroicon-m-arrow-down-tray', 'classes' => 'bg-blue-500'],
                            OrderStatus::COMPLETED => ['icon' => 'heroicon-m-check', 'classes' => 'bg-green-500'],
                            OrderStatus::CANCELED => ['icon' => 'heroicon-m-exclamation-triangle', 'classes' => 'bg-red-500'],
                            OrderStatus::SHORTED => ['icon' => 'heroicon-m-x-circle', 'classes' => 'bg-amber-500'],
                        }
                    @endphp
                    <div class="grid grid-cols-2 items-center px-2.5 text-white rounded-t-xl h-10 {{ $bannerStyle['classes'] }}">
                        <div class="flex items-center gap-2 justify-self-start leading-none">
                            <x-dynamic-component :component="$bannerStyle['icon']" class="size-5" />
                            <span class="font-semibold">{{ $order->readable_status }}</span>
                        </div>

                        @if(in_array($order->status, [OrderStatus::PENDING, OrderStatus::RESERVED]))
                            <span class="text-xl font-semibold justify-self-end" x-data="duration('{{ $order->status_changed_at }}')" x-text="timeElapsed"></span>
                        @else
                            <span class="text-sm font-semibold justify-self-end">{{ $order->status_changed_at->toDateString() }} at {{ $order->status_changed_at->toTimeString() }}</span>
                        @endif
                    </div>

                    <div class="border bg-white rounded-b-xl">
                        <div class="px-2.5 py-3">
                            <h4 class="text-sm text-gray-600">Order #{{ $order->id }}</h4>
                            <h3 class="text-lg text-gray-800 font-semibold">{{ $order->user->name }}</h3>
                        </div>

                        <ul class="divide-y border-y-4">
                            @foreach ($order->items as $item)
                                <li wire:key="{{ $item->id }}">
                                    <button wire:click="markOrderItemAsFulfilled({{ $item->id }})" class="flex px-2.5 py-3 gap-3 min-h-12 w-full text-left hover:bg-gray-50 duration-150">
                                        <div class="shrink-0 text-gray-600">{{ $item->quantity }}x</div>
                                        <div class="grow text-gray-800 font-semibold @if ($item->fulfilled) line-through @endif">{{ $item->product->name }}</div>
                                        <div class="shrink-0">
                                            <div class="flex items-center justify-center size-6 text-green-500">
                                                @if ($item->fulfilled)
                                                    <x-heroicon-s-check-circle />
                                                @else
                                                    <div class="size-5 rounded-full bg-gray-200"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="flex justify-between px-2.5 py-3">
                            <div class="text-gray-600 font-semibold">Total</div>
                            <div class="text-gray-800 font-bold">${{ number_format((float) $order->total, 2, '.', '') }}</div>
                        </div>

                        <div class="flex flex-col gap-2.5 p-2.5 rounded-b-xl">
                            <div class="space-y-2.5">
                                <x-ui.button.primary class="w-full" x-data="orderPrinter('{{ $order->id }}')" x-bind:disabled="printing" @click="printPdf">
                                    <x-slot name="left">
                                        <template x-if="!printing"><span><x-ui.button.icon icon="heroicon-m-printer" /></span></template>
                                        <template x-if="printing"><span><x-ui.button.icon icon="heroicon-m-arrow-path" class="animate-spin" /></span></template>
                                    </x-slot>

                                    <template x-if="!printing"><span>Print Label</span></template>
                                    <template x-if="printing"><span>Printing...</span></template>
                                </x-ui.button.primary>
                                <div class="grid grid-cols-2 gap-2.5">
                                    <x-ui.button.danger wire:click="$dispatch('openModal', { component: 'pos.cancel-order-modal', arguments: { order: {{ $order->id }} } })">
                                        <x-slot name="left">
                                            <x-ui.button.icon icon="heroicon-m-x-mark" />
                                        </x-slot>

                                        Cancel
                                    </x-ui.button.danger>
                                    @if($order->can_reserve)
                                        <x-ui.button.success wire:click="$dispatch('openModal', { component: 'pos.reserve-order-modal', arguments: { order: {{ $order->id }} } })">
                                            <x-slot name="left">
                                                <x-ui.button.icon icon="heroicon-m-check" />
                                            </x-slot>

                                            Reserve
                                        </x-ui.button.success>
                                    @elseif($order->can_complete)
                                        <x-ui.button.success wire:click="$dispatch('openModal', { component: 'pos.complete-order-modal', arguments: { order: {{ $order->id }} } })">
                                            <x-slot name="left">
                                                <x-ui.button.icon icon="heroicon-m-check" />
                                            </x-slot>

                                            Complete
                                        </x-ui.button.success>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endempty
</div>
