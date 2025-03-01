<?php

namespace App\Livewire\Pos\Modals;

use App\Exceptions\OrderCompletionException;
use App\Exceptions\OrderNotFoundException;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class CompleteOrderModal extends ModalComponent
{
    use Toastable;

    private OrderService $orderService;

    public Order $order;

    public function boot(OrderService $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function complete(): void
    {
        $this->authorizeForUser(auth('employee')->user(), 'complete', $this->order);

        try {
            $this->orderService->completeOrder($this->order->id, auth('employee')->user());

            $this->success("Order completed.");
        } catch (OrderNotFoundException|OrderCompletionException $e) {
            $this->error("Failed to complete order: " . $e->getMessage());
        } finally {
            $this->closeModal();
        }
    }

    public function render(): View
    {
        $this->authorizeForUser(auth('employee')->user(), 'view', $this->order);

        return view('livewire.pos.modals.complete-order-modal');
    }
}
