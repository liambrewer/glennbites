<ul class="grid grid-cols-2 gap-2.5">
    @foreach ($orders as $order)
        <li wire:key="{{ $order->id }}" class="flex flex-col">
            <div class="flex items-center gap-2.5 bg-blue-500 px-2.5 text-white rounded-t-xl h-10">
                <x-heroicon-m-clock class="size-5" />

                <span class="text-sm">Pending...</span>

                <div class="grow"></div>

                <span class="text-xl font-semibold" x-data="duration('{{ $order->created_at }}')" x-text="timeElapsed"></span>
            </div>

            <div class="flex flex-col gap-2.5 p-2.5 rounded-b-xl border border-t-0">
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

                <div class="space-y-1">
                    <button class="text-blue-600 font-semibold px-4 py-2 text-sm rounded-lg w-full hover:bg-blue-100 duration-150">Print Label</button>
                    <div class="flex gap-1">
                        <button class="bg-red-500 text-white font-semibold px-4 py-2 text-sm rounded-lg hover:bg-red-600 duration-150 shrink-0">Short</button>
                        <button class="bg-blue-500 text-white font-semibold px-4 py-2 text-sm rounded-lg hover:bg-blue-600 duration-150 grow">Mark as Reserved</button>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
