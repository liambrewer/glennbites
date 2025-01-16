<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case RESERVED = 'reserved';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case SHORTED = 'shorted';
}
