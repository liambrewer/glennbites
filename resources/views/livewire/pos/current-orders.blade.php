<ul class="grid grid-cols-2 gap-5">
    @foreach ($orders as $order)
        <li wire:key="{{ $order->id }}" class="flex flex-col">
            <div class="flex items-center gap-2.5 bg-blue-500 px-2.5 text-white rounded-t-xl h-10">
                <x-heroicon-m-clock class="size-5" />

                <span class="text-sm">Pending...</span>

                <div class="grow"></div>

                <span class="text-xl font-semibold" x-data="duration('{{ $order->created_at }}')" x-text="timeElapsed"></span>
            </div>

            <div class="flex flex-col gap-2.5 p-2.5 rounded-b-xl border border-t-0 bg-white">
                <div class="flex gap-2.5 items-center">
                    <span class="text-xl font-bold">{{ $order->user->name }}</span>

                    <div class="grow"></div>

                    <span class="text-gray-600 text-sm font-semibold">Order #{{ $order->id }}</span>
                </div>

                <div>
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
                    <x-ui.button.primary class="w-full">
                        <x-ui.button.icon icon="heroicon-m-printer" />

                        Print Label
                    </x-ui.button.primary>
                    <div class="grid grid-cols-2 gap-2.5">
                        <x-ui.button.danger wire:click="$dispatch('openModal', { component: 'pos.cancel-order-modal', arguments: { order: {{ $order->id }} } })">
                            <x-ui.button.icon icon="heroicon-m-x-mark" />

                            Cancel
                        </x-ui.button.danger>
                        <x-ui.button.success wire:click="$dispatch('openModal', { component: 'pos.confirm-order-modal', arguments: { order: {{ $order->id }} } })">
                            <x-ui.button.icon icon="heroicon-m-check" />

                            Complete
                        </x-ui.button.success>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
