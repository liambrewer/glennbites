<x-layouts.pos-layout>
    <h1 class="text-lg font-semibold mb-5">Home</h1>

    <div class="grid grid-cols-2 gap-5 justify-items-stretch place-items-start">
        <x-pos.dashboard-card title="Current Orders" icon="heroicon-c-rectangle-stack" :href="route('pos.orders.index')">
            <ul class="flex flex-col gap-2.5">
                @foreach($currentOrders as $order)
                    <li class="contents">
                        <x-pos.order-snippet :$order />
                    </li>
                @endforeach
            </ul>
        </x-pos.dashboard-card>

        <x-pos.dashboard-card title="Metrics" icon="heroicon-c-chart-bar" :href="route('pos.metrics')">
            <div class="grid grid-cols-3">
                <div class="flex flex-col items-center">
                    <div class="text-4xl text-gray-800 font-bold">{{ $currentOrders->count() }}</div>

                    <div class="text-sm text-gray-600">Current Orders</div>
                </div>
            </div>
        </x-pos.dashboard-card>
    </div>
</x-layouts.pos-layout>
