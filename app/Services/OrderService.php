<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Exceptions\ExceedsMaxPerOrderException;
use App\Exceptions\InvalidQuantityException;
use App\Exceptions\NotEnoughStockException;
use App\Exceptions\OrderCancellationException;
use App\Exceptions\OrderCompletionException;
use App\Exceptions\OrderCreationException;
use App\Exceptions\OutOfStockException;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(protected StockService $stockService)
    {
    }

    /**
     * @param User $user
     * @param array $items
     * @return Order
     * @throws NotEnoughStockException
     * @throws OrderCreationException
     */
    public function createOrder(User $user, array $items): Order
    {
        DB::beginTransaction();

        try {
            $this->validateOrderItems($items);

            $order = Order::make();
            $order->user()->associate($user);
            $order->total = 0;
            $order->save();

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                $this->stockService->reserveStock($product->id, $item['quantity'], $user, "Order #{$order->id}");

                $oi = OrderItem::make();
                $oi->order()->associate($order);
                $oi->product()->associate($product);
                $oi->quantity = $item['quantity'];
                $oi->price = $product->price;
                $oi->save();

                $order->total += $oi->total;
            }

            $order->total = round($order->total, 2);
            $order->save();

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function completeOrder(int $orderId, Employee $employee): Order
    {
        return DB::transaction(function () use ($orderId, $employee) {
            $order = Order::findOrFail($orderId);

            if (!$order->completable) {
                throw new OrderCompletionException("Order must be reserved before it can be marked as completed.");
            }

            $order->load('items');

            foreach ($order->items as $item) {
                $this->stockService->completeStock($item->product->id, $item->quantity, $employee, "Order #{$order->id} completed");
            }

            $order->status = OrderStatus::COMPLETED;
            $order->save();

            return $order;
        });
    }

    public function cancelOrder(int $orderId, User|Employee $actor): Order
    {
        return DB::transaction(function () use ($orderId, $actor) {
            $order = Order::findOrFail($orderId);

            if (!$order->cancellable) {
                throw new OrderCancellationException();
            }

            $order->load('items');

            foreach ($order->items as $item) {
                $this->stockService->releaseStock($item->product->id, $item->quantity, $actor, "Order #{$order->id} cancelled");
            }

            $order->status = OrderStatus::CANCELLED;
            $order->save();

            return $order;
        });
    }

    public function shortOrder(int $orderId, Employee $employee): Order
    {
        return DB::transaction(function () use ($orderId, $employee) {
            $order = Order::findOrFail($orderId);

            if (!$order->shortable) {
                throw ValidationException::withMessages(['order' => 'Order cannot be shorted.']);
            }

            $order->load('items');

            foreach ($order->items as $item) {
                $this->stockService->releaseStock($item->product->id, $item->quantity, $employee, "Order #{$order->id} shorted");
            }

            $order->status = OrderStatus::SHORTED;
            $order->save();

            return $order;
        });
    }

    /**
     * @param array $items
     * @return void
     * @throws OrderCreationException
     */
    protected function validateOrderItems(array $items): void
    {
        if (empty($items)) throw new OrderCreationException("Order is empty.");

        $productIds = array_column($items, 'product_id');

        if (count($productIds) !== count(array_unique($productIds))) throw new OrderCreationException("Order items must be unique.");

        try {
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $product->ensureValidQuantity($item['quantity']);
            }
        } catch (ExceedsMaxPerOrderException|InvalidQuantityException|NotEnoughStockException|OutOfStockException $e) {
            throw new OrderCreationException("Invalid Order: {$e->getMessage()}");
        }
    }
}
