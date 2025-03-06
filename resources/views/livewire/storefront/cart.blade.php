<?php

use App\Models\Cart;
use App\Services\CartService;
use App\Traits\Livewire\HasCartService;
use Livewire\Attributes\{Computed, Layout, Title};
use Livewire\Volt\Component;

new #[Title('Cart')] #[Layout('components.layouts.storefront-layout')] class extends Component {
    use HasCartService;

    public function increment($productId): void
    {
        $this->cartService->addToCart($productId, 1);
    }

    public function decrement($productId): void
    {
        $this->cartService->removeFromCart($productId, 1);
    }

    public function delete($productId): void
    {
        $this->cartService->deleteFromCart($productId);
    }

    #[Computed]
    public function cart(): Cart
    {
        return $this->cartService->getCart()->load('items.product');
    }
}; ?>

<div>
    <h1 class="text-xl font-semibold mb-4">Cart</h1>

    @unless ($this->cart->empty)
        <div class="grid lg:grid-cols-3 gap-4">
            <ul class="flex flex-col gap-4 lg:col-span-2">
                @foreach ($this->cart->items as $item)
                    <li class="flex flex-col gap-4 bg-white border p-4 rounded-xl">
                        <div class="flex gap-4">
                            <img class="size-20 object-cover rounded-lg" src="{{ $item->product->image_url }}"
                                 alt="Product Image" />

                            <div class="space-y-2">
                                <div>
                                    <h2 class="text-xl font-semibold">{{ $item->product->name }}</h2>

                                    @unless ($item->product->out_of_stock)
                                        <div class="text-sm text-green-500">
                                            {{ $item->product->available_stock }} units available
                                        </div>
                                    @else
                                        <div class="text-sm text-red-500">
                                            Out of Stock
                                        </div>
                                    @endunless
                                </div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex items-center bg-gray-100 text-gray-800 rounded-full h-8 w-fit gap-5">
                                        @if ($item->quantity === 1)
                                            <button wire:click="delete({{ $item->product->id }})"
                                                    class="size-8 flex items-center justify-center">
                                                <x-heroicon-c-trash class="size-4 ml-2"/>
                                            </button>
                                        @else
                                            <button wire:click="decrement({{ $item->product->id }})"
                                                    class="size-8 flex items-center justify-center">
                                                <x-heroicon-c-minus class="size-4 ml-2"/>
                                            </button>
                                        @endif
                                        <span class="font-bold">{{ $item->quantity }}</span>
                                        <button wire:click="increment({{ $item->product->id }})"
                                                class="size-8 flex items-center justify-center">
                                            <x-heroicon-c-plus class="size-4 mr-2"/>
                                        </button>
                                    </div>

                                    <button wire:click="delete({{ $item->product->id }})"
                                            class="text-red-500 text-xs hover:underline">Delete
                                    </button>
                                </div>
                            </div>

                            <div class="grow"></div>

                            <div>
                                <div class="text-gray-800">${{ number_format($item->product->price, 2) }} per unit</div>
                            </div>
                        </div>

                        @isset ($item->error_message)
                            <div class="border border-red-500 bg-red-200 text-red-900 p-4 rounded-lg">{{ $item->error_message }}</div>
                        @endisset
                    </li>
                @endforeach
            </ul>

            <div class="bg-white border p-4 rounded-xl h-fit space-y-4">
                <p class="text-gray-800">Please take time to review your cart and once ready, place your order!</p>

                <div>
                    <div class="text-sm font-semibold">Total Due</div>

                    <x-cash-and-card-totals :total="$this->cart->total" />
                </div>

                @unless ($this->cart->valid)
                    <p class="text-sm text-red-500">
                        Your cart contains invalid items and you cannot place your order at this time. Please review your cart.
                    </p>
                @endunless

                <x-ui.button.primary wire:click="$dispatch('openModal', { component: 'storefront.modals.confirm-place-order-modal' })" class="w-full" :disabled="!$this->cart->valid">
                    Place Order
                    <x-slot:right>
                        <x-ui.button.icon icon="heroicon-s-arrow-right" />
                    </x-slot:right>
                </x-ui.button.primary>
            </div>
        </div>
    @else
        Cart is empty!
    @endunless
</div>
