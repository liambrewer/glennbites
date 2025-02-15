<x-pos.order-card :$order>
    <ul class="divide-y border-y-4">
        @foreach ($order->items as $item)
            <li wire:key="{{ $item->id }}">
                <div class="flex px-2.5 py-3 gap-3 min-h-12 w-full">
                    <div class="shrink-0 text-gray-600">{{ $item->quantity }}x</div>
                    @if ($item->product->image_url)
                        <img class="size-6 border object-cover rounded" src="{{ $item->product->image_url }}" alt="Product Image">
                    @endif
                    <div class="grow text-gray-800 font-semibold">{{ $item->product->name }}</div>
                    <div class="shrink-0">
                        <div class="flex items-center justify-center size-6 text-green-500">
                            <x-heroicon-s-check-circle />
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="flex justify-between px-2.5 py-3">
        <div class="text-gray-600 font-semibold">Total</div>
        <div class="text-gray-800 font-bold">${{ number_format((float) $order->total, 2, '.', '') }}</div>
    </div>

    <div class="flex flex-col gap-2.5 p-2.5 rounded-b-xl">
        <div class="space-y-2.5">
            <div class="flex flex-col gap-2.5">
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
</x-pos.order-card>
