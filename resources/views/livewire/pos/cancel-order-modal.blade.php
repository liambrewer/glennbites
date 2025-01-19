<div class="flex flex-col gap-10 p-5">
    <div class="space-y-5">
        <h3 class="text-lg font-semibold">Cancel Order?</h3>

        <div class="space-y-2.5">
            <h4 class="font-semibold">Short Order</h4>

            <p class="text-gray-600">If an order cannot be completed due to circumstances outside of the customers control please mark it as shorted. This includes scenarios such as inadequate stock and invalid products. By shorting this order it will mark it as shorted and alert <span class="text-gray-800 font-semibold">{{ $order->user->name }}</span> that it was unable to be completed.</p>
        </div>

        <x-ui.button.danger class="w-full">
            <x-ui.button.icon icon="heroicon-m-question-mark-circle" />

            Short Order
        </x-ui.button.danger>

        <div class="space-y-2.5">
            <h4 class="font-semibold">Cancel Order</h4>

            <p class="text-gray-600">By canceling this order it will mark it as canceled and place a temporary suspension on <span class="text-gray-800 font-semibold">{{ $order->user->name }}</span>'s account.</p>
        </div>

        <x-ui.button.danger class="w-full">
            <x-ui.button.icon icon="heroicon-m-exclamation-triangle" />

            Cancel Order
        </x-ui.button.danger>
    </div>

    <x-ui.button wire:click="$dispatch('closeModal')" autofocus>Close</x-ui.button>
</div>
