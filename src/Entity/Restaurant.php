<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Interface\SoftDeleteableInterface;
use App\Interface\TimestampableInterface;
use App\Repository\RestaurentRepository;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\NameEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Asserts;

#[ApiResource()]
#[UniqueEntity(fields: ['name'])]
#[ORM\UniqueConstraint(fields: ['name'])]
#[ORM\Entity(repositoryClass: RestaurentRepository::class)]
class Restaurant implements TimestampableInterface, SoftDeleteableInterface
{
    use IdEntityTrait;
    use NameEntityTrait;
    use IsEnabledEntityTrait;
    use TimestampableEntityTrait;
    use SoftDeleteableEntityTrait;

    #[Asserts\Length(max: 255)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[Asserts\Length(max: 255)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[Asserts\Length(max: 10)]
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $postcode = null;

    public function __toString(): string
    {
        return (string) $this->getName();
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }
}
