<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case RESERVED = 'reserved';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
    case SHORTED = 'shorted';
}
