<div class="flex flex-col gap-5 p-5">
    <h3 class="text-lg font-semibold">Complete Order?</h3>

    <x-pos.order-snippet :$order />

    <p class="text-gray-600">By completing this order you confirm that payment was collected and the order was given to <span class="text-gray-800 font-semibold">{{ $order->user->name }}</span>.</p>

    <div class="grid grid-cols-2 gap-2.5">
        <x-ui.button wire:click="$dispatch('closeModal')" autofocus>Close</x-ui.button>
        @if($order->can_complete && auth('employee')->user()->can('complete', $order))
            <x-ui.button.success wire:click="complete" wire:loading.attr="disabled" wire:target="complete">
                <x-ui.button.icon wire:loading.remove wire:target="complete" icon="heroicon-m-check" />
                <x-ui.button.icon wire:loading wire:target="complete" icon="heroicon-m-arrow-path" class="animate-spin" />

                <span wire:loading.remove wire:target="complete">Complete</span>
                <span wire:loading wire:target="complete">Completing...</span>
            </x-ui.button.success>
        @else
            <x-ui.button disabled>Unavailable</x-ui.button>
        @endif
    </div>
</div>
