<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
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
        new Put(),
        new Post(),
        new Patch(),
        new Delete(),
    ],
    security: 'is_granted("ROLE_ADMIN")'
)]
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
