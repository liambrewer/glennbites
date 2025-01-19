<?php

namespace App\Livewire\Pos;

use App\Models\Order;
use LivewireUI\Modal\ModalComponent;

class ConfirmOrderModal extends ModalComponent
{
    public Order $order;

    public function render()
    {
        return view('livewire.pos.confirm-order-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }
}
