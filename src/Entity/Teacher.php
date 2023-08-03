<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Interface\SoftDeleteableInterface;
use App\Interface\TimestampableInterface;
use App\Repository\TeacherRepository;
use App\Trait\EmailEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\NameEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\SurnameEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource(
    operations: [
        new Get(security: 'is_granted("PUBLIC_ACCESS")'),
        new GetCollection(security: 'is_granted("PUBLIC_ACCESS")'),
    ],
    security: 'is_granted("ROLE_ADMIN")'
)]
#[UniqueEntity(fields: ['email'])]
#[ORM\UniqueConstraint(fields: ['email'])]
#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher implements TimestampableInterface, SoftDeleteableInterface
{
    use EmailEntityTrait;
    use IdEntityTrait;
    use IsEnabledEntityTrait;
    use NameEntityTrait;
    use SoftDeleteableEntityTrait;
    use SurnameEntityTrait;
    use TimestampableEntityTrait;

    #[ORM\ManyToMany(targetEntity: Language::class, mappedBy: 'teachers', fetch: 'EXTRA_LAZY')]
    private Collection $languages;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName().' '.$this->getSurname();
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
            $language->addTeacher($this);
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        if ($this->languages->removeElement($language)) {
            $language->removeTeacher($this);
        }

        return $this;
    }
}
