<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Events\OrderCanceled;
use App\Events\OrderCompleted;
use App\Events\OrderCreated;
use App\Events\OrderReserved;
use App\Events\OrderShorted;
use App\Exceptions\ExceedsMaxPerOrderException;
use App\Exceptions\InvalidQuantityException;
use App\Exceptions\NotEnoughStockException;
use App\Exceptions\OrderCancellationException;
use App\Exceptions\OrderCompletionException;
use App\Exceptions\OrderCreationException;
use App\Exceptions\OrderNotFoundException;
use App\Exceptions\OrderReservationException;
use App\Exceptions\OrderShortException;
use App\Exceptions\OutOfStockException;
use App\Exceptions\ProductNotFoundException;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

            OrderCreated::dispatch($order);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @param int $orderId
     * @param Employee $employee
     * @return Order
     * @throws OrderNotFoundException
     * @throws OrderReservationException
     */
    public function reserveOrder(int $orderId, Employee $employee): Order
    {
        DB::beginTransaction();

        try {
            $order = $this->lockedOrder($orderId);

            if (!$order->can_reserve) throw new OrderReservationException();

            $order->status = OrderStatus::RESERVED;
            $order->status_changed_at = now();
            $order->save();

            OrderReserved::dispatch($order);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @param int $orderId
     * @param Employee $employee
     * @return Order
     * @throws OrderCompletionException
     * @throws OrderNotFoundException
     */
    public function completeOrder(int $orderId, Employee $employee): Order
    {
        DB::beginTransaction();

        try {
            $order = $this->lockedOrder($orderId);

            if (!$order->can_complete) throw new OrderCompletionException();

            $order->load('items');

            foreach ($order->items as $item) {
                $this->stockService->completeStock($item->product->id, $item->quantity, $employee, "Order #{$order->id} completed");
            }

            $order->status = OrderStatus::COMPLETED;
            $order->status_changed_at = now();
            $order->save();

            OrderCompleted::dispatch($order);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @param int $orderId
     * @param User|Employee $actor
     * @return Order
     * @throws OrderCancellationException
     * @throws OrderNotFoundException
     */
    public function cancelOrder(int $orderId, User|Employee $actor): Order
    {
        DB::beginTransaction();

        try {
            $order = $this->lockedOrder($orderId);

            if (!$order->can_cancel) throw new OrderCancellationException();

            $order->load('items');

            foreach ($order->items as $item) {
                $this->stockService->releaseStock($item->product->id, $item->quantity, $actor, "Order #{$order->id} cancelled");
            }

            $order->status = OrderStatus::CANCELED;
            $order->status_changed_at = now();
            $order->save();

            OrderCanceled::dispatch($order);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @param int $orderId
     * @param Employee $employee
     * @return Order
     * @throws OrderNotFoundException
     * @throws OrderShortException
     */
    public function shortOrder(int $orderId, Employee $employee): Order
    {
        DB::beginTransaction();

        try {
            $order = $this->lockedOrder($orderId);

            if (!$order->can_short) throw new OrderShortException();

            $order->load('items');

            foreach ($order->items as $item) {
                $this->stockService->releaseStock($item->product->id, $item->quantity, $employee, "Order #{$order->id} shorted");
            }

            $order->status = OrderStatus::SHORTED;
            $order->status_changed_at = now();
            $order->save();

            OrderShorted::dispatch($order);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
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
                $product = Product::find($item['product_id'])->first();

                if (!$product) throw new ProductNotFoundException();

                $product->ensureValidQuantity($item['quantity']);
            }
        } catch (ExceedsMaxPerOrderException|InvalidQuantityException|NotEnoughStockException|OutOfStockException|ProductNotFoundException $e) {
            throw new OrderCreationException("Invalid Order: {$e->getMessage()}");
        }
    }

    /**
     * @param int $orderId
     * @return Order
     * @throws OrderNotFoundException
     */
    protected function lockedOrder(int $orderId): Order
    {
        $order = Order::lockForUpdate()->find($orderId);

        if (!$orderId) throw new OrderNotFoundException();

        return $order;
    }
}
