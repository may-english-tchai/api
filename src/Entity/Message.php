<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    security: 'is_granted("ROLE_USER")'
)]
#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message extends Content
{
    #[ORM\ManyToOne]
    private ?User $fromUser = null;

    #[ORM\ManyToOne]
    private ?User $toUser = null;

    public function getFromUser(): ?User
    {
        return $this->fromUser;
    }

    public function setFromUser(?User $fromUser): self
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    public function getToUser(): ?User
    {
        return $this->toUser;
    }

    public function setToUser(?User $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }
}
