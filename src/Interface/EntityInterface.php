<?php

declare(strict_types=1);

namespace App\Interface;

use Symfony\Component\Uid\Uuid;

interface EntityInterface extends \Stringable
{
    public function getId(): ?Uuid;

    public function setId(Uuid|string $id): static;
}
