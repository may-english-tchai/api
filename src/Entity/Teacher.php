<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TeacherRepository;
use App\Trait\EmailEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\NameEntityTrait;
use App\Trait\SoftDeleteableEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource()]
#[UniqueEntity(fields: ['email'])]
#[ORM\UniqueConstraint(fields: ['email'])]
#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    use IdEntityTrait;
    use NameEntityTrait;
    use EmailEntityTrait;
    use IsEnabledEntityTrait;
    use TimestampableEntityTrait;
    use SoftDeleteableEntityTrait;

    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\ManyToMany(targetEntity: Language::class, mappedBy: 'teachers')]
    private Collection $languages;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
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
