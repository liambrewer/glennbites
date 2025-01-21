<div class="flex flex-col gap-5 p-5">
    <h3 class="text-lg font-semibold">Reserve Order?</h3>

    <x-pos.order-snippet :$order />

    <p class="text-gray-600">By reserving this order it will mark it as reserved and alert <span class="text-gray-800 font-semibold">{{ $order->user->name }}</span> that it is ready to be picked up.</p>

    <div class="grid grid-cols-2 gap-2.5">
        <x-ui.button wire:click="$dispatch('closeModal')" autofocus>Close</x-ui.button>
        <x-ui.button.primary wire:click="reserve" wire:loading.attr="disabled" wire:target="reserve">
            <x-ui.button.icon wire:loading.remove wire:target="reserve" icon="heroicon-m-check" />
            <x-ui.button.icon wire:loading wire:target="reserve" icon="heroicon-m-arrow-path" class="animate-spin" />

            <span wire:loading.remove wire:target="reserve">Reserve</span>
            <span wire:loading wire:target="reserve">Reserving...</span>
        </x-ui.button.primary>
    </div>
</div>
