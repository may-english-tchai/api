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
    ]
)]
#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Contact extends Content
{
    use EmailEntityTrait;
}
