<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use App\Trait\CodeEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\LabelEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[UniqueEntity(fields: ['code'])]
#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    use IdEntityTrait;
    use CodeEntityTrait;
    use LabelEntityTrait;
    use IsEnabledEntityTrait;

    #[ORM\ManyToMany(targetEntity: Teacher::class, inversedBy: 'languages')]
    private Collection $teachers;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): self
    {
        $this->teachers->removeElement($teacher);

        return $this;
    }
}
