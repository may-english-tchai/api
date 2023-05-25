<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AvailabilityStatusRepository;
use App\Trait\CodeEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\LabelEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource]
#[UniqueEntity(fields: ['code'])]
#[ORM\Entity(repositoryClass: AvailabilityStatusRepository::class)]
class AvailabilityStatus
{
    use IdEntityTrait;
    use CodeEntityTrait;
    use LabelEntityTrait;
}
