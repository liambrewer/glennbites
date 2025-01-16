<?php

namespace App\Exceptions;

use Exception;

class OutOfStockException extends Exception
{
    protected $message = 'This product is out of stock.';
}
