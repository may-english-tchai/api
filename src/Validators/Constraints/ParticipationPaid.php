<?php

namespace App\Validators\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class ParticipationPaid extends Constraint
{
    public string $message = 'This participation is already paid.';

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}
