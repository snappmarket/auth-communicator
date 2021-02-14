<?php

namespace SnappMarket\Auth\Exceptions;

use Exception;
use Throwable;

class LoginException extends Exception
{
    private $statusCode;
    
    public function __construct($message = "", $code = 0, Throwable $previous = null, ?int $statusCode = null)
    {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }
}

