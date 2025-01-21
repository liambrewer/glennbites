@php
/* @var App\Models\Order[] $orders */

use App\Enums\OrderStatus;
@endphp

<ul class="grid grid-cols-2 gap-5">
    @foreach ($orders as $order)
        <li wire:key="{{ $order->id }}" class="flex flex-col">
            @php
                $bannerStyle = match ($order->status) {
                    OrderStatus::PENDING => ['icon' => 'heroicon-m-clock', 'classes' => 'bg-yellow-500'],
                    OrderStatus::RESERVED => ['icon' => 'heroicon-m-arrow-down-tray', 'classes' => 'bg-blue-500'],
                    OrderStatus::COMPLETED => ['icon' => 'heroicon-m-check', 'classes' => 'bg-green-500'],
                    OrderStatus::CANCELLED => ['icon' => 'heroicon-m-exclamation-triangle', 'classes' => 'bg-red-500'],
                    OrderStatus::SHORTED => ['icon' => 'heroicon-m-x-circle', 'classes' => 'bg-amber-500'],
                }
            @endphp
            <div class="flex items-center gap-2.5 px-2.5 text-white rounded-t-xl h-10 {{ $bannerStyle['classes'] }}">
                <x-dynamic-component :component="$bannerStyle['icon']" class="size-5" />

                <span class="text-sm">{{ $order->readable_status }}</span>

                <div class="grow"></div>

                @if(in_array($order->status, [OrderStatus::PENDING, OrderStatus::RESERVED]))
                    <span class="text-xl font-semibold" x-data="duration('{{ $order->status_changed_at }}')" x-text="timeElapsed"></span>
                @else
                    <span class="text-sm font-semibold">{{ $order->status_changed_at->toDateString() }} at {{ $order->status_changed_at->toTimeString() }}</span>
                @endif
            </div>

            <div class="flex flex-col gap-2.5 p-2.5 rounded-b-xl border border-t-0 bg-white grow">
                <div class="flex gap-2.5 items-center">
                    <span class="text-xl font-bold">{{ $order->user->name }}</span>

                    <div class="grow"></div>

                    <span class="text-gray-600 text-sm font-semibold">Order #{{ $order->id }}</span>
                </div>

                <div class="grow">
                    <div class="text-gray-600 text-sm font-semibold">Order Items</div>

                    <ul class="flex flex-col">
                        @foreach ($order->items as $item)
                            <li wire:key="{{ $item->id }}" class="flex gap-2.5">
                                <div class="text-gray-800 text-lg font-bold">{{ $item->quantity }}x {{ $item->product->name }} - ${{ number_format((float) $item->total, 2, '.', '') }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="space-y-2.5">
                    <x-ui.button.primary class="w-full" x-data="orderPrinter('{{ $order->id }}')" x-bind:disabled="printing" @click="printPdf">
                        <template x-if="!printing"><span><x-ui.button.icon icon="heroicon-m-printer" /></span></template>
                        <template x-if="printing"><span><x-ui.button.icon icon="heroicon-m-arrow-path" class="animate-spin" /></span></template>

                        <template x-if="!printing"><span>Print Label</span></template>
                        <template x-if="printing"><span>Printing...</span></template>
                    </x-ui.button.primary>
                    <div class="grid grid-cols-2 gap-2.5">
                        <x-ui.button.danger wire:click="$dispatch('openModal', { component: 'pos.cancel-order-modal', arguments: { order: {{ $order->id }} } })">
                            <x-ui.button.icon icon="heroicon-m-x-mark" />

                            Cancel
                        </x-ui.button.danger>
                        <x-ui.button.success wire:click="$dispatch('openModal', { component: 'pos.reserve-order-modal', arguments: { order: {{ $order->id }} } })">
                            <x-ui.button.icon icon="heroicon-m-check" />

                            Reserve
                        </x-ui.button.success>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
