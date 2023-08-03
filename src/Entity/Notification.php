<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Enum\NotificationTypeEnum;
use App\Repository\NotificationRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[Get(security: 'is_granted("ROLE_USER")')]
#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification extends Content
{
    #[ORM\ManyToOne]
    private ?User $toUser = null;

    #[ORM\Column]
    private ?string $event = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $readAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $archivedAt = null;

    #[ORM\Column(enumType: NotificationTypeEnum::class)]
    private NotificationTypeEnum $type = NotificationTypeEnum::info;

    public function getToUser(): ?User
    {
        return $this->toUser;
    }

    public function setToUser(?User $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }

    public function setType(NotificationTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): NotificationTypeEnum
    {
        return $this->type;
    }

    public function setReadAt(?DateTime $readAt): self
    {
        $this->readAt = $readAt;

        return $this;
    }

    public function getReadAt(): ?DateTime
    {
        return $this->readAt;
    }

    public function setArchivedAt(?DateTime $archivedAt): self
    {
        $this->archivedAt = $archivedAt;

        return $this;
    }

    public function getArchivedAt(): ?DateTime
    {
        return $this->archivedAt;
    }

    public function setEvent(?string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }
}
