<?php

namespace App\Livewire\Pos;

use App\Models\Order;
use LivewireUI\Modal\ModalComponent;

class CancelOrderModal extends ModalComponent
{
    public Order $order;

    public function render()
    {
        return view('livewire.pos.cancel-order-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }
}
