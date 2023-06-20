<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class Content implements EntityInterface
{
    use IdEntityTrait;
    use IsEnabledEntityTrait;
    use TimestampableEntityTrait;
    use SoftDeleteableEntityTrait;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    public function __toString(): string
    {
        return (string) $this->getSubject();
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }
}
