<?php

namespace App\Livewire\Pos;

use App\Models\Order;
use Livewire\Component;

class CurrentOrders extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::with('user', 'items', 'items.product')->get();
    }

    public function render()
    {
        return view('livewire.pos.current-orders');
    }
}
