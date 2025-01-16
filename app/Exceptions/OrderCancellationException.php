<?php

namespace App\Exceptions;

use Exception;

class OrderCancellationException extends Exception
{
    protected $message = 'An error occurred while canceling this order.';
}
