<?php

namespace App\Models;

use App\Exceptions\ExceedsMaxPerOrderException;
use App\Exceptions\InvalidQuantityException;
use App\Exceptions\NotEnoughStockException;
use App\Exceptions\OutOfStockException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->product->price;
    }

    public function getErrorMessageAttribute(): ?string
    {
        try {
            $this->validateQuantity();
        } catch (ExceedsMaxPerOrderException | InvalidQuantityException | NotEnoughStockException | OutOfStockException $e) {
            return $e->getMessage();
        }

        return null;
    }

    /**
     * @throws ExceedsMaxPerOrderException
     * @throws InvalidQuantityException
     * @throws NotEnoughStockException
     * @throws OutOfStockException
     */
    public function validateQuantity(): void
    {
        $this->product->ensureValidQuantity($this->quantity);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
