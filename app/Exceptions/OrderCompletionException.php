<?php

namespace App\Exceptions;

use Exception;

class OrderCompletionException extends Exception
{
    protected $message = 'An error occurred while completing this order.';
}
