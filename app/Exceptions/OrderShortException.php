<?php

namespace App\Exceptions;

use Exception;

class OrderShortException extends Exception
{
    protected $message = 'An error occurred while shorting this order.';
}
