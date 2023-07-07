<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Enum\PaymentStatusEnum;
use App\Interface\SoftDeleteableInterface;
use App\Interface\TimestampableInterface;
use App\Repository\PaymentRepository;
use App\Trait\AmountEntityTrait;
use App\Trait\CommentEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource(
    operations: [
        new Get(),
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

    #[ORM\Column(nullable: false, enumType: PaymentStatusEnum::class)]
    private ?PaymentStatusEnum $status = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $reference = null;

    /** @var array<string, mixed> */
    #[ORM\Column(type: Types::JSON)]
    private array $data = [];

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

    public function setStatus(?PaymentStatusEnum $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): ?PaymentStatusEnum
    {
        return $this->status;
    }

    public function getStatusLabel(): ?string
    {
        return $this->status?->value;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @throws \JsonException
     */
    public function getDataToJson(): false|string
    {
        return json_encode($this->data, JSON_THROW_ON_ERROR);
    }
}
