<?php

namespace App\Entity;

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
