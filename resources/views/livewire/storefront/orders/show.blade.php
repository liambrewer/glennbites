<?php

use App\Models\Order;
use Livewire\Volt\Component;

new class extends Component {
    public Order $order;

    public function rendering(\Illuminate\View\View $view): void
    {
        $this->authorizeForUser(auth('web')->user(), 'view', $this->order);

        $view->title("Order #{$this->order->id} Details");
        $view->layout('components.layouts.storefront-layout', [
            'header' => "Order #{$this->order->id}",
            'back' => route('storefront.orders.index'),
        ]);
    }
}; ?>

<div>
    {{ $order->id }}
</div>
