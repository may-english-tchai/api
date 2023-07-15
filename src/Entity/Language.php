<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Interface\EntityInterface;
use App\Repository\LanguageRepository;
use App\Trait\CodeEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\LabelEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ApiResource(
    operations: [
        new Get(security: 'is_granted("PUBLIC_ACCESS")'),
        new GetCollection(security: 'is_granted("PUBLIC_ACCESS")'),
        new Put(),
        new Post(),
        new Patch(),
        new Delete(),
    ],
    security: 'is_granted("ROLE_ADMIN")'
)]
#[UniqueEntity(fields: ['code'])]
#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language implements EntityInterface
{
    use CodeEntityTrait;
    use IdEntityTrait;
    use IsEnabledEntityTrait;
    use LabelEntityTrait;

    #[ORM\ManyToMany(targetEntity: Teacher::class, inversedBy: 'languages')]
    private Collection $teachers;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getLabel();
    }

    /**
     * @return Collection<int, Teacher>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): self
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
            $teacher->addLanguage($this);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): self
    {
        $this->teachers->removeElement($teacher);

        return $this;
    }
}
