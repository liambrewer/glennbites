<?php

namespace App\Livewire\Storefront\Modals;

use App\Models\Cart;
use App\Traits\Livewire\HasCartService;
use App\Traits\Livewire\HasOrderService;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class ConfirmPlaceOrderModal extends ModalComponent
{
    use HasOrderService, HasCartService, Toastable;

    public Cart $cart;

    public function mount(): void
    {
        $this->cart = $this->cartService->getCart()->load('items.product');
    }

    public function placeOrder(): void
    {
        try {
            $order = $this->orderService->createOrder(auth('web')->user(), $this->cart->transformToOrderItems());

            $this->cartService->clearCart();

            $this->success('Order placed.');

            $this->redirect(route('storefront.orders.show', $order));
        } catch (\Exception $e) {
            $this->error('Failed to place order: '.$e->getMessage());
        } finally {
            $this->closeModal();
        }
    }

    public function render(): View
    {
        return view('livewire.storefront.modals.confirm-place-order-modal');
    }
}
