<x-pos.order-card :$order>
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
</x-pos.order-card>
