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
     */
    public function getCanReserveAttribute(): bool
    {
        if (! $this->relationLoaded('items')) {
            $this->load('items');
        }

        if ($this->items->isEmpty()) {
            return false;
        }

        $allItemsFulfilled = $this->items->every(fn (OrderItem $item) => $item->fulfilled);

        return $this->status === OrderStatus::PENDING && $allItemsFulfilled;
    }

    /**
     * Order may only be completed if it is reserved.
     */
    public function getCanCompleteAttribute(): bool
    {
        return $this->status === OrderStatus::RESERVED;
    }

    /**
     * Order may only be cancelled if it is pending or reserved.
     */
    public function getCanCancelAttribute(): bool
    {
        return in_array($this->status, [OrderStatus::PENDING, OrderStatus::RESERVED]);
    }

    /**
     * Order may only be shorted if it is pending.
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

    public function getWireKeyAttribute(): string
    {
        return "order-{$this->id}-status-{$this->status->value}";
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

    public function scopePending(Builder $query): Builder
    {
        return $query->whereIn('status', [OrderStatus::PENDING]);
    }

    public function scopeReserved(Builder $query): Builder
    {
        return $query->whereIn('status', [OrderStatus::RESERVED]);
    }
}
