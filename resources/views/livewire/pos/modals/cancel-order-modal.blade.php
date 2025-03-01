<div class="flex flex-col gap-10 p-5">
    <div class="space-y-5">
        <h3 class="text-lg font-semibold">Cancel Order?</h3>

        <x-pos.order-snippet :$order />

        <div class="space-y-2.5">
            <h4 class="font-semibold">Short Order</h4>

            <p class="text-gray-600">If an order cannot be completed due to circumstances outside of the customers control please mark it as shorted. This includes scenarios such as inadequate stock and invalid products. By shorting this order it will mark it as shorted and alert <span class="text-gray-800 font-semibold">{{ $order->user->name }}</span> that it was unable to be completed.</p>
        </div>

        @if($order->can_short && auth('employee')->user()->can('short', $order))
            <x-ui.button.danger wire:click="short" wire:loading.attr="disabled" wire:target="short, cancel" class="w-full">
                <x-ui.button.icon wire:loading.remove wire:target="short" icon="heroicon-m-question-mark-circle" />
                <x-ui.button.icon wire:loading wire:target="short" icon="heroicon-m-arrow-path" class="animate-spin" />

                <span wire:loading.remove wire:target="short">Short Order</span>
                <span wire:loading wire:target="short">Shorting Order...</span>
            </x-ui.button.danger>
        @else
            <x-ui.button class="w-full" disabled>Unavailable</x-ui.button>
        @endif

        <div class="space-y-2.5">
            <h4 class="font-semibold">Cancel Order</h4>

            <p class="text-gray-600">By canceling this order it will mark it as canceled and place a temporary suspension on <span class="text-gray-800 font-semibold">{{ $order->user->name }}</span>'s account.</p>
        </div>

        @if($order->can_cancel && auth('employee')->user()->can('cancel', $order))
            <x-ui.button.danger wire:click="cancel" wire:loading.attr="disabled" wire:target="short, cancel" class="w-full">
                <x-ui.button.icon wire:loading.remove wire:target="cancel" icon="heroicon-m-exclamation-triangle" />
                <x-ui.button.icon wire:loading wire:target="cancel" icon="heroicon-m-arrow-path" class="animate-spin" />

                <span wire:loading.remove wire:target="cancel">Cancel Order</span>
                <span wire:loading wire:target="cancel">Canceling Order...</span>
            </x-ui.button.danger>
        @else
            <x-ui.button class="w-full" disabled>Unavailable</x-ui.button>
        @endif
    </div>

    <x-ui.button wire:click="$dispatch('closeModal')" autofocus>Close</x-ui.button>
</div>
