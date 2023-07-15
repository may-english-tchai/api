<?php

namespace App\Validators\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class MaxCapacity extends Constraint
{
    public string $message = 'The maximum capacity for the appointment has been reached.';

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}
