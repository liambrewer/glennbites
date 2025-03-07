<?php

use Livewire\Attributes\{Computed, Title, Layout};
use Livewire\Volt\Component;

new
#[Title('Orders')]
#[Layout('components.layouts.storefront-layout', [
    'header' => 'Orders',
])]
class extends Component {
    #[Computed]
    public function orders()
    {
        return auth('web')->user()->orders()->with('items.product')->get();
    }
}; ?>

<div>
    <ul>
        @foreach ($this->orders as $order)
            <li>
                <a wire:navigate href="{{ route('storefront.orders.show', $order) }}">
                    Order #{{ $order->id }}

                    @can ('view', $order)
                        <span class="text-sm text-gray-500">- {{ $order->status }}</span>
                        you can view
                    @endcan
                </a>
            </li>
        @endforeach
    </ul>
</div>
