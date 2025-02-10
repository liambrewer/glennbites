<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'status_changed_at' => 'datetime',
    ];

    /**
     * Order may only be reserved if it is pending.
     *
     * @return bool
     */
    public function getCanReserveAttribute(): bool
    {
        return $this->status === OrderStatus::PENDING;
    }

    /**
     * Order may only be completed if it is reserved.
     *
     * @return bool
     */
    public function getCanCompleteAttribute(): bool
    {
        return $this->status === OrderStatus::RESERVED;
    }

    /**
     * Order may only be cancelled if it is pending or reserved.
     *
     * @return bool
     */
    public function getCanCancelAttribute(): bool
    {
        return in_array($this->status, [OrderStatus::PENDING, OrderStatus::RESERVED]);
    }

    /**
     * Order may only be shorted if it is pending.
     *
     * @return bool
     */
    public function getCanShortAttribute(): bool
    {
        return $this->status === OrderStatus::PENDING;
    }

    public function getReadableStatusAttribute(): string
    {
        return match ($this->status) {
            OrderStatus::PENDING => 'Pending',
            OrderStatus::RESERVED => 'Reserved',
            OrderStatus::COMPLETED => 'Completed',
            OrderStatus::CANCELED => 'Canceled',
            OrderStatus::SHORTED => 'Shorted',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeCurrent(Builder $query): Builder
    {
        return $query->whereIn('status', [OrderStatus::PENDING, OrderStatus::RESERVED]);
    }
}
