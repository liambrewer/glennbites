<?php

namespace App\Livewire\Pos\Modals;

use App\Exceptions\OrderCancellationException;
use App\Exceptions\OrderNotFoundException;
use App\Exceptions\OrderShortException;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class CancelOrderModal extends ModalComponent
{
    use Toastable;

    private OrderService $orderService;

    public Order $order;

    public function boot(OrderService $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function short(): void
    {
        $this->authorizeForUser(auth('employee')->user(), 'short', $this->order);

        try {
            $this->orderService->shortOrder($this->order->id, auth('employee')->user());

            $this->success("Order shorted.");
        } catch (OrderNotFoundException|OrderShortException $e) {
            $this->error("Failed to short order: " . $e->getMessage());
        } finally {
            $this->closeModal();
        }
    }

    public function cancel(): void
    {
        $this->authorizeForUser(auth('employee')->user(), 'cancel', $this->order);

        try {
            $this->orderService->cancelOrder($this->order->id, auth('employee')->user());

            $this->success("Order canceled.");
        } catch (OrderNotFoundException|OrderCancellationException $e) {
            $this->error("Failed to cancel order: " . $e->getMessage());
        } finally {
            $this->closeModal();
        }
    }

    public function render(): View
    {
        $this->authorizeForUser(auth('employee')->user(), 'view', $this->order);

        return view('livewire.pos.modals.cancel-order-modal');
    }
}
