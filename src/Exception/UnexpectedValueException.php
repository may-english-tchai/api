<?php

declare(strict_types=1);

namespace App\Exception;

use App\Interface\AppExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class UnexpectedValueException extends HttpException implements AppExceptionInterface, HttpExceptionInterface
{
}
