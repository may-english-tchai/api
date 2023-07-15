<?php

namespace App\Exception;

use App\Interface\AppExceptionInterface;
use Exception;
use Throwable;

class EntityValidationException extends Exception implements AppExceptionInterface
{
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
