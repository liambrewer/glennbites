<?php

namespace App\Models;

use \Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Employee extends Authenticatable
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
}
