<?php

namespace App\Exceptions;

use Exception;

class OrderCreationException extends Exception
{
    protected $message = 'An error occurred while placing your order.';

    public static function notEnoughStock($productName, $requestedQuantity, $availableQuantity)
    {
        return new static("Cannot order {$requestedQuantity} units of {$productName}, only {$availableQuantity} available.");
    }

    public static function exceedsMaxPerOrder($productName, $requestedQuantity, $maxPerOrder)
    {
        return new static("Cannot order {$requestedQuantity} units of {$productName} because it exceeds the maximum units per order of {$maxPerOrder}.");
    }
}
