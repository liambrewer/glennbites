@props(['order', 'actions'])

@use(App\Enums\OrderStatus)

<li class="flex flex-col">
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

    <div class="border-x border-b bg-white rounded-b-xl shadow">
        <div class="px-2.5 py-3">
            <h4 class="text-sm text-gray-600">Order #{{ $order->id }}</h4>
            <h3 class="text-lg text-gray-800 font-semibold">{{ $order->user->name }}</h3>
        </div>

        {{ $slot }}

        <div class="flex items-center justify-between px-2.5 py-3">
            <div class="text-gray-600 font-semibold">Total</div>

            <x-pos.cash-and-card-totals :total="$order->total" />
        </div>

        @isset ($actions)
            <div class="flex flex-col gap-2.5 p-2.5">
                {{ $actions }}
            </div>
        @endif
    </div>
</li>
