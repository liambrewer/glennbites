<?php

namespace App\Livewire\Pos;

use App\Models\Order;
use Illuminate\View\View;
use Livewire\Component;

class ReservedOrderCard extends Component
{
    public Order $order;

    public function render(): View
    {
        $this->authorizeForUser(auth('employee')->user(), 'view', $this->order);

        return view('livewire.pos.reserved-order-card');
    }
}
