<div class="flex flex-col gap-5 p-5">
    <h3 class="text-lg font-semibold">Place Order?</h3>

    <p class="text-gray-600">By placing this order you agree to pay ${{ number_format($cart->total, 2) }} (cash) or ${{ number_format($cart->total + config('pricing.credit_card_fee'), 2) }} (card).</p>

    <x-cash-and-card-totals :total="$cart->total" />

    <div class="grid grid-cols-2 gap-2.5">
        <x-ui.button wire:click="$dispatch('closeModal')" autofocus>Close</x-ui.button>
{{--        @if($order->can_complete && auth('employee')->user()->can('complete', $order))--}}
        @if ($cart->valid)
            <x-ui.button.success wire:click="placeOrder" wire:loading.attr="disabled" wire:target="placeOrder">
                <x-ui.button.icon wire:loading.remove wire:target="placeOrder" icon="heroicon-s-check" />
                <x-ui.button.icon wire:loading wire:target="placeOrder" icon="heroicon-s-arrow-path" class="animate-spin" />

                <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                <span wire:loading wire:target="placeOrder">Placing Order...</span>
            </x-ui.button.success>
        @else
            <x-ui.button disabled>Unavailable</x-ui.button>
        @endif
    </div>
</div>
