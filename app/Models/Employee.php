<?php

namespace App\Models;

use App\Contracts\Authorizable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable implements Authorizable
{
    protected $fillable = [
        'name',
        'employee_number',
        'pin',
    ];

    protected $hidden = ['pin'];

    protected $casts = [
        'pin' => 'hashed',
    ];

    public function getAuthPassword(): string
    {
        return $this->pin;
    }

    public function stockMovements(): MorphMany
    {
        return $this->morphMany(StockMovement::class, 'actor');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isEmployee(): bool
    {
        return true;
    }
}
