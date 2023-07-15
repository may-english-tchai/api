<?php

namespace App\Validators\Constraints;

use App\Entity\Availability;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

use function count;

class MaxCapacityValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof MaxCapacity) {
            throw new UnexpectedTypeException($constraint, MaxCapacity::class);
        }

        if (!$value instanceof Availability) {
            return;
        }

        // Mettez ici la logique de validation pour vérifier si la capacité maximale est dépassée
        // $value représente l'objet ou la valeur à valider
        // Exemple :
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
