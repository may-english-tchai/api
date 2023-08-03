<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TestimonyRepository;
use App\Trait\NameEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(security: 'is_granted("PUBLIC_ACCESS")'),
        new GetCollection(security: 'is_granted("PUBLIC_ACCESS")'),
        new Put(security: 'is_granted("ROLE_USER") || object.getFromUser() === user'),
        new Post(security: 'is_granted("ROLE_USER")'),
        new Patch(security: 'is_granted("ROLE_USER") || object.getFromUser() === user'),
        new Delete(security: 'is_granted("ROLE_USER") || object.getFromUser() === user'),
    ],
    denormalizationContext: ['groups' => ['write:testimony', 'write', 'name:write', 'content:write']]
)]
#[ORM\Entity(repositoryClass: TestimonyRepository::class)]
class Testimony extends Content
{
    use NameEntityTrait;

    #[ORM\ManyToOne]
    #[Groups('testimony')]
    private ?User $fromUser = null;

    public function getFromUser(): ?User
    {
        return $this->fromUser;
    }

    public function setFromUser(?User $fromUser): self
    {
        $this->fromUser = $fromUser;

        return $this;
    }
}
