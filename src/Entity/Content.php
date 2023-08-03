<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
class Content implements EntityInterface
{
    use IdEntityTrait;
    use IsEnabledEntityTrait;
    use SoftDeleteableEntityTrait;
    use TimestampableEntityTrait;

    #[Groups(['content', 'content:write'])]
    #[ORM\Column(nullable: true)]
    private ?string $subject = null;

    #[Assert\NotBlank]
    #[Groups(['content', 'content:write'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    public function __toString(): string
    {
        return (string) $this->getSubject();
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }
}
