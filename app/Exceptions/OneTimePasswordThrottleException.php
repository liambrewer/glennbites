<?php

namespace App\Exceptions;

use Exception;

class OneTimePasswordThrottleException extends Exception
{
    public function __construct(string|int $minutes, string|int $seconds)
    {
        $message = "Too many codes requested. Please wait {$minutes} minutes and {$seconds} seconds before trying again.";
        parent::__construct($message);
    }
}
