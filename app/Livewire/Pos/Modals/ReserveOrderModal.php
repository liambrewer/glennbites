<?php

namespace App\Livewire\Pos\Modals;

use App\Exceptions\OrderNotFoundException;
use App\Exceptions\OrderReservationException;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class ReserveOrderModal extends ModalComponent
{
    use Toastable;

    private OrderService $orderService;

    public Order $order;

    public function boot(OrderService $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function reserve(): void
    {
        $this->authorizeForUser(auth('employee')->user(), 'reserve', $this->order);

        try {
            $this->orderService->reserveOrder($this->order->id, auth('employee')->user());

            $this->success('Order reserved.');
        } catch (OrderNotFoundException|OrderReservationException $e) {
            $this->error('Failed to reserve order: '.$e->getMessage());
        } finally {
            $this->closeModal();
        }
    }

    public function render(): View
    {
        $this->authorizeForUser(auth('employee')->user(), 'view', $this->order);

        return view('livewire.pos.modals.reserve-order-modal');
    }
}
