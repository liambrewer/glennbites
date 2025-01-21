<?php

namespace App\Exceptions;

use Exception;

class OrderReservationException extends Exception
{
    protected $message = 'An error occurred while reserving this order.';
}
