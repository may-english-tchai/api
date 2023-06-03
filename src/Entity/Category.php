<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\CategoryRepository;
use App\Trait\CodeEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\LabelEntityTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category implements EntityInterface
{
    use IdEntityTrait;
    use CodeEntityTrait;
    use LabelEntityTrait;

    public function __toString(): string
    {
        return (string) $this->getLabel();
    }
}
