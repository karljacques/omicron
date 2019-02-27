<?php

namespace App\Exceptions;


use Throwable;

// User action exceptions can be displayed back to the user
class UserActionException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
