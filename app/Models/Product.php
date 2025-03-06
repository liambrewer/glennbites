<?php

namespace App\Models;

use App\Exceptions\ExceedsMaxPerOrderException;
use App\Exceptions\InvalidQuantityException;
use App\Exceptions\NotEnoughStockException;
use App\Exceptions\OutOfStockException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock_on_hand',
        'reserved_stock',
        'max_per_order',
        'image_url',
    ];

    public function getAvailableStockAttribute(): int
    {
        return $this->stock_on_hand - $this->reserved_stock;
    }

    public function getOutOfStockAttribute(): int
    {
        return $this->available_stock <= 0;
    }

    /**
     * Validates that a given quantity of an item is permitted.
     *
     * @throws OutOfStockException
     * @throws InvalidQuantityException
     * @throws ExceedsMaxPerOrderException
     * @throws NotEnoughStockException
     */
    public function ensureValidQuantity(int $quantity): void
    {
        if ($this->out_of_stock) {
            throw new OutOfStockException;
        }
        if ($quantity < 1) {
            throw new InvalidQuantityException('Quantity must be greater than 1.');
        }
        if ($this->max_per_order && $quantity > $this->max_per_order) {
            throw new ExceedsMaxPerOrderException("You cannot order more than {$this->max_per_order} units of {$this->name}.");
        }
        if ($quantity > $this->available_stock) {
            throw new NotEnoughStockException("Not enough stock for {$this->name}. Only {$this->available_stock} left.");
        }
    }

    public function getFavoriteAttribute(): bool
    {
        return $this->favoredBy()->where('user_id', auth('web')->id())->exists();
    }

    public function toggleFavorite(): void
    {
        if ($this->favorite) {
            $this->favoredBy()->detach(auth('web')->id());
        } else {
            $this->favoredBy()->attach(auth('web')->id());
        }
    }

    public function favoredBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Favorite::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
