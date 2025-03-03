<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'onboarded_at' => 'timestamp',
    ];

    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function getOnboardedAttribute(): bool
    {
        return $this->onboarded_at !== null;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function stockMovements(): MorphMany
    {
        return $this->morphMany(StockMovement::class, 'actor');
    }

    public function oneTimePasswords(): HasMany
    {
        return $this->hasMany(OneTimePassword::class);
    }
}
