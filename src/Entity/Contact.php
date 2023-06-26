<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\MessageRepository;
use App\Trait\EmailEntityTrait;
use App\Trait\NameEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(security: 'is_granted("PUBLIC_ACCESS")'),
        new Get(),
    ]
)]
#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Contact extends Content
{
    use NameEntityTrait;
    use EmailEntityTrait;

    #[Assert\Length(min: 10)]
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $phone = null;

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
}
