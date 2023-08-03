<?php

namespace App\Entity;

use App\Enum\ConfigEnum;
use App\Enum\TypeValueEnum;
use App\Interface\EntityInterface;
use App\Repository\ConfigRepository;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ConfigRepository::class)]
class Config implements EntityInterface
{
    use IdEntityTrait;
    use IsEnabledEntityTrait;
    use TimestampableEntityTrait;

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[ORM\Column(unique: true, enumType: ConfigEnum::class)]
        private ?ConfigEnum $name = null,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[Assert\NotNull]
        #[ORM\Column]
        private ?string $value = null,

        #[Assert\NotBlank]
        #[Assert\NotNull]
        #[ORM\Column(length: 20, enumType: TypeValueEnum::class)]
        private ?TypeValueEnum $type = null,
    ) {
    }

    public function getName(): ?ConfigEnum
    {
        return $this->name;
    }

    public function setName(ConfigEnum $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): ?TypeValueEnum
    {
        return $this->type;
    }

    public function setType(TypeValueEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->name?->value;
    }
}
