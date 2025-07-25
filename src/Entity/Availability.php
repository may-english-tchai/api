<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Interface\SoftDeleteableInterface;
use App\Interface\TimestampableInterface;
use App\Repository\AvailabilityRepository;
use App\Trait\CommentEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\PriceEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\TimestampableEntityTrait;
use App\Validators\Constraints\MaxCapacity;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource(
    operations: [
        new Get(security: 'is_granted("PUBLIC_ACCESS")'),
        new GetCollection(security: 'is_granted("PUBLIC_ACCESS")'),
        new Put(security: 'is_granted("ROLE_TEACHER")'),
        new Post(security: 'is_granted("ROLE_TEACHER")'),
        new Patch(security: 'is_granted("ROLE_TEACHER")'),
        new Delete(security: 'is_granted("ROLE_TEACHER")'),
    ],
    order: ['start' => 'ASC']
)]
#[ApiFilter(SearchFilter::class, properties: ['isEnabled' => 'exact'])]
#[ApiFilter(DateFilter::class, properties: ['start'])]
#[ApiFilter(OrderFilter::class, properties: ['start'])]
#[UniqueEntity(fields: ['start', 'teacher'])]
#[ORM\UniqueConstraint(fields: ['start', 'teacher'])]
#[ORM\Entity(repositoryClass: AvailabilityRepository::class)]
#[MaxCapacity]
class Availability implements TimestampableInterface, SoftDeleteableInterface
{
    use CommentEntityTrait;
    use IdEntityTrait;
    use IsEnabledEntityTrait;
    use PriceEntityTrait;
    use SoftDeleteableEntityTrait;
    use TimestampableEntityTrait;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeInterface $start = null;

    #[ORM\Column(options: ['default' => 60])]
    private ?int $duration = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Restaurant $restaurant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Teacher $teacher = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $language = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?AvailabilityStatus $status = null;

    #[ORM\OneToMany(mappedBy: 'availability', targetEntity: Participation::class, orphanRemoval: true)]
    private Collection $participations;

    #[ORM\Column(nullable: true)]
    private ?int $capacity = null;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf(
            '%s - %s - %s',
            $this->getStart()?->format('d/m/y H:i'),
            $this->getTeacher(),
            $this->getRestaurant(),
        );
    }

    public function getStart(): ?DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getStatus(): ?AvailabilityStatus
    {
        return $this->status;
    }

    public function setStatus(?AvailabilityStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setAvailability($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        // set the owning side to null (unless already changed)
        if (!$this->participations->removeElement($participation)) {
            return $this;
        }

        if ($participation->getAvailability() !== $this) {
            return $this;
        }

        $participation->setAvailability(null);

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }
}
