<?php

use App\Models\Favorite;
use App\Models\Product;
use App\Traits\Livewire\HasCartService;
use Livewire\Attributes\{Computed, Title, Layout};
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Masmerise\Toaster\Toastable;

new #[Title('Products')] #[Layout('components.layouts.storefront-layout')] class extends Component {
    use HasCartService, Toastable;

    public function addToCart(int $productId): void
    {
        $this->cartService->addToCart($productId, 1);

        $this->success('Product added to cart.');
    }

    public function toggleFavorite(int $productId): void
    {
        $product = Product::findOrFail($productId);

        $product->toggleFavorite();
    }

    #[Computed]
    public function products()
    {
        return Product::all();
    }
}; ?>

<ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($this->products as $product)
        <li wire:key="{{ $product->id }}" class="flex flex-col bg-white border rounded-xl shadow-sm p-4 gap-2">
            <img src="{{ $product->image_url }}" alt="Product Image"
                 class="max-w-full aspect-[16/9] object-cover rounded-lg border" />

            <div>
                <h1 class="text-base sm:text-lg font-semibold">{{ $product->name }}</h1>
                <p class="text-sm sm:text-base text-gray-600">{{ $product->description }}</p>
            </div>

            <div class="grow"></div>

            <div class="flex gap-2 flex-wrap">
                <div class="bg-gray-100 px-2 py-0.5 rounded-full">
                    <span class="font-semibold">${{ $product->price }}</span> <span class="text-xs">each</span>
                </div>

                <div class="bg-green-500 text-white px-2 py-0.5 rounded-full">
                    <span class="font-semibold">{{ $product->available_stock }}</span> <span
                        class="text-xs">available</span>
                </div>

                <div class="bg-gradient-to-r from-[#FFD700] to-[#EBB866] text-black px-2 py-0.5 rounded-full">
                    <span class="font-semibold">#1</span> <span class="text-xs">best seller</span>
                </div>
            </div>

            <div class="flex gap-2">
                <x-ui.button wire:click="toggleFavorite({{ $product->id }})">
                    @if ($product->favorite)
                        <x-ui.button.icon wire:loading.remove wire:target="toggleFavorite({{ $product->id }})"
                                          icon="heroicon-s-star" class="text-yellow-400" />
                    @else
                        <x-ui.button.icon wire:loading.remove wire:target="toggleFavorite({{ $product->id }})"
                                          icon="heroicon-o-star" />
                    @endif
                    <x-ui.button.icon wire:loading wire:target="toggleFavorite({{ $product->id }})"
                                      icon="heroicon-s-arrow-path" class="animate-spin" />
                </x-ui.button>

                <x-ui.button.primary wire:click="addToCart({{ $product->id }})" wire:loading.attr="disabled"
                                     wire:target="addToCart({{ $product->id }})" class="grow">
                    <x-slot:left>
                        <x-ui.button.icon wire:loading.remove wire:target="addToCart({{ $product->id }})"
                                          icon="heroicon-s-plus" />
                        <x-ui.button.icon wire:loading wire:target="addToCart({{ $product->id }})"
                                          icon="heroicon-s-arrow-path" class="animate-spin" />
                    </x-slot:left>

                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                    <span wire:loading wire:target="addToCart({{ $product->id }})">Adding to Cart...</span>
                </x-ui.button.primary>
            </div>
        </li>
    @endforeach
</ul>
