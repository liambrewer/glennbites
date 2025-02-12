<?php

namespace App\Livewire;

use App\Models\User;
use App\Services\OrderService;
use Illuminate\View\View;
use Livewire\Component;

class CreateFakeOrder extends Component
{
    private OrderService $orderService;

    public function boot(OrderService $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function create(): void
    {
        $this->orderService->createOrder(User::findOrFail(1), [
            ['product_id' => 1, 'quantity' => 2],
            ['product_id' => 2, 'quantity' => 1],
        ]);
    }

    public function render(): View
    {
        return view('livewire.create-fake-order');
    }
}
