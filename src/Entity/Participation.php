<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Enum\PaymentStatusEnum;
use App\Interface\SoftDeleteableInterface;
use App\Interface\TimestampableInterface;
use App\Repository\ParticipationRepository;
use App\Trait\AmountEntityTrait;
use App\Trait\CommentEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(security: 'is_granted("PUBLIC_ACCESS")'),
        new GetCollection(security: 'is_granted("PUBLIC_ACCESS")'),
        new Put(),
        new Patch(),
    ],
    security: 'is_granted("ROLE_USER")'
)]
#[UniqueEntity(fields: ['availability', 'user'])]
#[ORM\UniqueConstraint(fields: ['availability', 'user'])]
#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation implements TimestampableInterface, SoftDeleteableInterface
{
    use AmountEntityTrait;
    use CommentEntityTrait;
    use IdEntityTrait;
    use SoftDeleteableEntityTrait;
    use TimestampableEntityTrait;

    #[ORM\Column(nullable: true)]
    private ?int $note = null;

    /**
     * @param Collection<int, Payment> $payments
     */
    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'participations')]
        #[ORM\JoinColumn(nullable: false)]
        private ?User $user = null,

        #[Assert\Valid]
        #[ORM\ManyToOne(inversedBy: 'participations')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Availability $availability = null,

        #[ORM\OneToMany(mappedBy: 'participation', targetEntity: Payment::class, orphanRemoval: true)]
        private Collection $payments = new ArrayCollection(),
    ) {
        $this->amount = $availability?->getPrice() ?? 0;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s - %s',
            $this->isPaid() ? '✅' : '❌',
            $this->getAvailability(),
            $this->getUser()
        );
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAvailability(): ?Availability
    {
        return $this->availability;
    }

    public function setAvailability(?Availability $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setParticipation($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        // set the owning side to null (unless already changed)
        if (!$this->payments->removeElement($payment)) {
            return $this;
        }

        if ($payment->getParticipation() !== $this) {
            return $this;
        }

        $payment->setParticipation(null);

        return $this;
    }

    public function isPaid(): bool
    {
        $total = 0;
        $this->payments->map(static function (Payment $payment) use (&$total) {
            if (PaymentStatusEnum::paid === $payment->getStatus()) {
                $total += $payment->getAmount();
            }
        });

        return $total >= $this->amount;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }
}
