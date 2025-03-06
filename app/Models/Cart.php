<?php

namespace App\Models;

use App\Exceptions\ExceedsMaxPerOrderException;
use App\Exceptions\InvalidQuantityException;
use App\Exceptions\NotEnoughStockException;
use App\Exceptions\OutOfStockException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getTotalAttribute(): float
    {
        return $this->items->sum('total');
    }

    public function getValidAttribute(): bool
    {
        if ($this->empty) {
            return false;
        }

        try {
            $this->items->each(fn (CartItem $item) => $item->validateQuantity());
        } catch (ExceedsMaxPerOrderException | InvalidQuantityException | NotEnoughStockException | OutOfStockException) {
            return false;
        }

        return true;
    }

    public function getEmptyAttribute(): bool
    {
        return $this->items->isEmpty();
    }

    public function transformToOrderItems(): array
    {
        return $this->items->map(fn (CartItem $item) => [
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
        ])->toArray();
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
