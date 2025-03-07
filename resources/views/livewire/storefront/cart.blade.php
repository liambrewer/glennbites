<?php

use App\Models\Cart;
use App\Services\CartService;
use App\Traits\Livewire\HasCartService;
use Livewire\Attributes\{Computed, Layout, Title};
use Livewire\Volt\Component;

new
#[Title('Cart')]
#[Layout('components.layouts.storefront-layout', [
    'header' => 'Cart',
])]
class extends Component {
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
    @unless ($this->cart->empty)
        <div class="grid lg:grid-cols-3 gap-4">
            <ul class="flex flex-col gap-4 lg:col-span-2">
                @foreach ($this->cart->items as $item)
                    <li class="flex flex-col gap-4 bg-white border p-4 rounded-xl">
                        <div class="flex gap-4">
                            <img class="size-20 object-cover rounded-lg" src="{{ $item->product->image_url }}"
                                 alt="Product Image" />

                            <div class="flex items-center gap-2">
                                <div>
                                    <h2 class="text-gray-800 text-sm md:text-lg">{{ $item->product->name }}</h2>

                                    @unless ($item->product->out_of_stock)
                                        <div class="text-xs md:text-sm text-green-500">
                                            {{ $item->product->available_stock }} units available
                                        </div>
                                    @else
                                        <div class="text-sm text-red-500">
                                            Out of Stock
                                        </div>
                                    @endunless

                                    <div class="font-medium text-lg md:hidden">${{ number_format($item->product->price, 2) }}</div>
                                </div>
                            </div>

                            <div class="grow"></div>

                            <div class="font-medium text-xl hidden md:block">${{ number_format($item->product->price, 2) }}</div>
                        </div>

                        <div class="flex items-center gap-2">
                            <div
                                class="flex items-center bg-gray-100 text-gray-800 rounded-full h-8 w-fit gap-5 px-2">
                                @if ($item->quantity === 1)
                                    <button wire:click="delete({{ $item->product->id }})" wire:loading.attr="disabled" wire:target="delete({{ $item->product->id }})" class="flex items-center justify-center size-8 p-2">
                                        <x-heroicon-c-trash wire:loading.remove wire:target="delete({{ $item->product->id }})" />
                                        <x-heroicon-c-arrow-path wire:loading wire:target="delete({{ $item->product->id }})" class="animate-spin" />
                                    </button>
                                @else
                                    <button wire:click="decrement({{ $item->product->id }})" wire:loading.attr="disabled" wire:target="decrement({{ $item->product->id }})" class="flex items-center justify-center size-8 p-2">
                                        <x-heroicon-c-minus wire:loading.remove wire:target="decrement({{ $item->product->id }})" />
                                        <x-heroicon-c-arrow-path wire:loading wire:target="decrement({{ $item->product->id }})" class="animate-spin" />
                                    </button>
                                @endif

                                <span class="font-medium">{{ $item->quantity }}</span>

                                <button wire:click="increment({{ $item->product->id }})" wire:loading.attr="disabled" wire:target="increment({{ $item->product->id }})" class="flex items-center justify-center size-8 p-2">
                                    <x-heroicon-c-plus wire:loading.remove wire:target="increment({{ $item->product->id }})" />
                                    <x-heroicon-c-arrow-path wire:loading wire:target="increment({{ $item->product->id }})" class="animate-spin" />
                                </button>
                            </div>

                            <button wire:click="delete({{ $item->product->id }})" class="text-red-500 text-xs hover:underline">
                                Delete
                            </button>
                        </div>

                        @isset ($item->error_message)
                            <p class="text-sm text-red-500">
                                {{ $item->error_message }}
                            </p>
                        @endisset
                    </li>
                @endforeach
            </ul>

            <div class="bg-white border p-4 rounded-xl h-fit space-y-4">
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
        <div class="bg-white border rounded-xl min-h-48 flex flex-col items-center justify-center gap-4 py-4">
            <p class="text-gray-800">Your cart is empty.</p>

            <x-ui.button.primary wire:navigate :href="route('storefront.products')" class="ml-4">
                Browse Products
                <x-slot:right>
                    <x-ui.button.icon icon="heroicon-s-arrow-right" />
                </x-slot:right>
            </x-ui.button.primary>
        </div>
    @endunless
</div>
