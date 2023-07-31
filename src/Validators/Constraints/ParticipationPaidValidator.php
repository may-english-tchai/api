<?php

namespace App\Validators\Constraints;

use App\Entity\Payment;
use App\Enum\PaymentStatusEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ParticipationPaidValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ParticipationPaid) {
            throw new UnexpectedTypeException($constraint, MaxCapacity::class);
        }

        if (!$value instanceof Payment) {
            return;
        }

        $exists = $value->getParticipation()
            ?->getPayments()
            ->exists(static fn (int $key, Payment $payment) => $value->getId() !== $payment->getId()
                && PaymentStatusEnum::paid === $payment->getStatus());

        if (false === $exists) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
