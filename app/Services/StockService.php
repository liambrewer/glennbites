<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Exceptions\InvalidStockAdjustmentException;
use App\Exceptions\NotEnoughStockException;
use App\Models\Employee;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * @throws NotEnoughStockException
     */
    public function reserveStock(int $productId, int $quantity, User|Employee|null $actor = null, ?string $reason = null): Product
    {
        DB::beginTransaction();

        try {
            $product = Product::lockForUpdate()->findOrFail($productId);

            if ($quantity > $product->available_stock) {
                throw new NotEnoughStockException("There is not enough stock of {$product->name}. Requested {$quantity} units. On-hand {$product->stock_on_hand} units - Reserved {$product->reserved_stock} units = Available {$product->available_stock} units");
            }

            $product->reserved_stock += $quantity;
            $product->save();

            $this->logMovement($productId, $quantity, StockMovementType::RESERVE, $actor, $reason);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function releaseStock(int $productId, int $quantity, User|Employee|null $actor = null, ?string $reason = null): Product
    {
        DB::beginTransaction();

        try {
            $product = Product::lockForUpdate()->findOrFail($productId);

            $product->reserved_stock = max(0, $product->reserved_stock - $quantity);
            $product->save();

            $this->logMovement($productId, -$quantity, StockMovementType::RELEASE, $actor, $reason);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @throws InvalidStockAdjustmentException
     */
    public function adjustStock(int $productId, int $quantity, ?Employee $actor = null, ?string $reason = null): Product
    {
        DB::beginTransaction();

        try {
            $product = Product::lockForUpdate()->find($productId);

            $newStockOnHand = $product->stock_on_hand + $quantity;

            if ($newStockOnHand < $product->reserved_stock) {
                throw new InvalidStockAdjustmentException('The stock may not be adjusted under the current reserved stock number. Please release stock if further adjustment is required.');
            }

            $product->stock_on_hand = $newStockOnHand;
            $product->save();

            $this->logMovement($productId, $quantity, StockMovementType::MANUAL_ADJUSTMENT, $actor, $reason);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function completeStock(int $productId, int $quantity, ?Employee $actor = null, ?string $reason = null): Product
    {
        DB::beginTransaction();

        try {
            $product = Product::lockForUpdate()->findOrFail($productId);

            $newStockOnHand = $product->stock_on_hand - $quantity;
            $newReservedStock = $product->reserved_stock - $quantity;

            $product->stock_on_hand = max(0, $newStockOnHand);
            $product->reserved_stock = max(0, $newReservedStock);
            $product->save();

            $this->logMovement($productId, $quantity, StockMovementType::ORDER_COMPLETE, $actor, $reason);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function logMovement(int $productId, int $quantity, StockMovementType $type, User|Employee|null $actor = null, ?string $reason = null): void
    {
        StockMovement::create([
            'product_id' => $productId,
            'quantity_change' => $quantity,
            'type' => $type->value,
            'actor_id' => optional($actor)->id,
            'actor_type' => $actor ? get_class($actor) : null,
            'reason' => $reason,
        ]);
    }
}
