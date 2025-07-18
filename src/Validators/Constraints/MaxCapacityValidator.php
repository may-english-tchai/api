<?php

namespace App\Validators\Constraints;

use App\Entity\Availability;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

use function count;

class MaxCapacityValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof MaxCapacity) {
            throw new UnexpectedTypeException($constraint, MaxCapacity::class);
        }

        if (!$value instanceof Availability) {
            return;
        }

        if (null === $value->getCapacity()) {
            return;
        }

        if (count($value->getParticipations()) < $value->getCapacity()) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
