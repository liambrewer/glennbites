<?php

namespace App\Models;

use App\Contracts\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements Authorizable
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

    protected $hidden = [
        'remember_token',
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

    public function favoriteProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, Favorite::class);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isEmployee(): bool
    {
        return false;
    }
}
