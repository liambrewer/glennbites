@props(['order'])

@php
/* @var App\Models\Order $order */
@endphp

<div class="bg-slate-50 p-2.5 rounded-lg space-y-2.5 border border-slate-300">
    <div class="flex items-center justify-between">
        <div>
            <div class="text-sm text-gray-600 font-semibold">Order #{{ $order->id }}</div>
            <div class="text-gray-800 font-semibold">{{ $order->user->name }}</div>
        </div>

        <x-pos.order-status-chip :status="$order->status" />
    </div>

    <div class="w-full h-[1px] bg-slate-300"></div>

    <ul class="mt-2.5">
        @foreach($order->items as $item)
            <li class="flex items-center justify-between">
                <div class="text-gray-800 font-semibold"><span>{{ $item->quantity }}x</span> <span class="text-lg">{{ $item->product->name }}</span></div>

                <div class="text-sm text-gray-600">${{ number_format((float) $item->total, 2, '.', '') }}</div>
            </li>
        @endforeach

            <li class="flex items-center justify-between">
                <div class="text-lg text-gray-800 font-semibold">Total</div>

                <div class="text-sm text-gray-600">${{ number_format((float) $order->total, 2, '.', '') }}</div>
            </li>
    </ul>
</div>
