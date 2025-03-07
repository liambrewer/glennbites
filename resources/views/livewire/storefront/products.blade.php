<?php

use App\Models\Favorite;
use App\Models\Product;
use App\Traits\Livewire\HasCartService;
use Livewire\Attributes\{Computed, Title, Layout, Url};
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Masmerise\Toaster\Toastable;

new
#[Title('Products')]
#[Layout('components.layouts.storefront-layout', [
    'header' => 'Products',
])]
class extends Component {
    use HasCartService, Toastable;

    #[Url]
    public string $search = '';

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
        // return the users favored items first and then the rest of the products
        return Product::withFavoritesSorted()
            ->when(!empty($this->search), fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->orderBy('name', 'asc')
            ->get();
    }
}; ?>

<div class="space-y-4">
    <div class="flex">
        @php
            $searchClasses = 'flex items-center gap-2 duration-300 ease-in-out transform mx-auto md:mx-0';
            $searchClasses .= !empty($this->search) ? ' grow' : ' w-fit';
        @endphp

        <div class="{{ $searchClasses }}">
            <x-heroicon-s-magnifying-glass wire:loading.remove wire:target="search" class="text-gray-500 size-4" />
            <x-heroicon-s-arrow-path wire:loading wire:target="search" class="text-gray-500 animate-spin size-4" />

            <x-ui.input.text wire:model.live.debounce="search" name="search" placeholder="Search products..." class="w-full" />

            @if (!empty($this->search))
                <x-ui.button wire:click="$set('search', '')">
                    <x-ui.button.icon icon="heroicon-s-x-mark" />
                </x-ui.button>
            @endif
        </div>
    </div>

    @if (!empty($this->search))

        <div class="bg-white border rounded-xl shadow-sm p-4">
            <h1 class="text-lg font-semibold">Search Results</h1>
            <p class="text-sm text-gray-600">Showing results for "{{ $this->search }}"</p>
        </div>

    @endif

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
</div>
