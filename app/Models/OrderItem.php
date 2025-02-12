<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'fulfilled_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format((float) $this->price, 2, '.', '');
    }

    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format((float) $this->total, 2, '.', '');
    }

    public function fulfilled(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => (bool) $attributes['fulfilled_at'],
            set: fn (bool $value) => ['fulfilled_at' => $value ? now() : null],
        );
    }
}
