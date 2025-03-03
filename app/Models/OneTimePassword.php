<?php

namespace App\Models;

use App\Enums\OneTimePasswordStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class OneTimePassword extends Model
{
    use HasUuids;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'status' => OneTimePasswordStatus::class,
        'code' => 'hashed',
    ];

    public function getUrlAttribute(): string
    {
        return URL::temporarySignedRoute('storefront.auth.show-one-time-password-form', now()->addMinutes(5), [
            'otp' => $this,
            'sid' => Request::session()->getId(),
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
