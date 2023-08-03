<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Interface\EntityInterface;
use App\Repository\AvailabilityStatusRepository;
use App\Trait\CodeEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\LabelEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource(
    operations: [
        new Get(security: 'is_granted("PUBLIC_ACCESS")'),
        new GetCollection(security: 'is_granted("PUBLIC_ACCESS")'),
    ],
    security: 'is_granted("ROLE_ADMIN")'
)]
#[UniqueEntity(fields: ['code'])]
#[ORM\Entity(repositoryClass: AvailabilityStatusRepository::class)]
class AvailabilityStatus implements EntityInterface
{
    use CodeEntityTrait;
    use IdEntityTrait;
    use LabelEntityTrait;

    public function __toString(): string
    {
        return (string) $this->getLabel();
    }
}
