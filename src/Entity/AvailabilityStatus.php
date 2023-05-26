<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Interface\EntityInterface;
use App\Repository\AvailabilityStatusRepository;
use App\Trait\CodeEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\LabelEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource]
#[UniqueEntity(fields: ['code'])]
#[ORM\Entity(repositoryClass: AvailabilityStatusRepository::class)]
class AvailabilityStatus implements EntityInterface
{
    use IdEntityTrait;
    use CodeEntityTrait;
    use LabelEntityTrait;

    public function __toString(): string
    {
        return (string) $this->getLabel();
    }
}
