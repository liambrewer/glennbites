<div class="flex flex-col gap-5 p-5">
    <h3 class="text-lg font-semibold">Confirm Order?</h3>

    <p class="text-gray-600">By confirming this order it will mark it as reserved and alert <span class="text-gray-800 font-semibold">{{ $order->user->name }}</span> that it is ready to be picked up.</p>

    <div class="grid grid-cols-2 gap-2.5">
        <x-ui.button wire:click="$dispatch('closeModal')" autofocus>Close</x-ui.button>
        <x-ui.button.primary>Ready for Pickup</x-ui.button.primary>
    </div>
</div>
