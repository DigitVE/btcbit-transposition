<?php

namespace App\Exceptions;

use Throwable;

class TranspositionOutOfRangeException extends \Exception
{
    public function __construct($message = 'Out of keyboard range error', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
