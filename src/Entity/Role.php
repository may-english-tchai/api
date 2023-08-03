<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\RoleRepository;
use App\Trait\CodeEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\LabelEntityTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role implements EntityInterface
{
    use CodeEntityTrait;
    use IdEntityTrait;
    use LabelEntityTrait;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'roles')]
    private Collection $users;

    public function __toString()
    {
        return (string) $this->getLabel();
    }

    public function setUsers(Collection $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }
}
