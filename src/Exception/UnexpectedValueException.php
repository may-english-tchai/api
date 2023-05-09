<?php

declare(strict_types=1);

namespace App\Exception;

use App\Interface\AppExceptionInterface;

class UnexpectedValueException extends \Exception implements AppExceptionInterface
{
}
