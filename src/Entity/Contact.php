<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\MessageRepository;
use App\Trait\EmailEntityTrait;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new Post(security: 'is_granted("PUBLIC_ACCESS")'),
        new Get,
    ]
)]
#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Contact extends Content
{
    use EmailEntityTrait;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $phone;

    public function getphone(): ?string
    {
        return $this->phone;
    }

    public function setphone(?string $phone): void
    {
        $this->phone = $phone;
    }
}
