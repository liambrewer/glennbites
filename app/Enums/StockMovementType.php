<?php

namespace App\Enums;

enum StockMovementType: string
{
    case RESERVE = 'reserve';
    case RELEASE = 'release';
    case MANUAL_ADJUSTMENT = 'manual_adjustment';
    case ORDER_COMPLETE = 'order_complete';
}
