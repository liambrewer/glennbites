<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LoginToken extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function getUsedAttribute(): bool
    {
        return $this->used_at !== null;
    }

    public function getExpiredAttribute(): bool
    {
        return $this->expires_at->isPast();
    }

    public function markAsUsed(): bool
    {
        return $this->update(['used_at' => now()]);
    }

    public static function generateForEmail(string $email, int $minutes = 30): self
    {
        return static::create([
            'email' => $email,
            'token' => Str::random(64),
            'expires_at' => now()->addMinutes($minutes),
        ]);
    }

    public static function findValidToken(string $token): ?self
    {
        return static::where('token', $token)
            ->where('used_at', null)
            ->where('expires_at', '>', now())
            ->first();
    }
}
