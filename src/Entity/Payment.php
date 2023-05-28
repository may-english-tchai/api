<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Interface\SoftDeleteableInterface;
use App\Interface\TimestampableInterface;
use App\Repository\PaymentRepository;
use App\Trait\AmountEntityTrait;
use App\Trait\CommentEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Put(),
        new Post(),
        new Patch(),
        new Delete(),
    ],
    security: 'is_granted("ROLE_USER")'
)]
#[UniqueEntity(fields: ['reference'])]
#[ORM\UniqueConstraint(fields: ['reference'])]
#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment implements TimestampableInterface, SoftDeleteableInterface
{
    use IdEntityTrait;
    use AmountEntityTrait;
    use CommentEntityTrait;
    use TimestampableEntityTrait;
    use SoftDeleteableEntityTrait;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $reference = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participation $participation = null;

    public function __toString(): string
    {
        return sprintf('%s - %s', $this->getReference(), $this->getParticipation());
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getParticipation(): ?Participation
    {
        return $this->participation;
    }

    public function setParticipation(?Participation $participation): self
    {
        $this->participation = $participation;

        return $this;
    }
}
