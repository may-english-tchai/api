<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GraphQl\Query;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Interface\TimestampableInterface;
use App\Repository\UserRepository;
use App\Resolver\User\MeResolver;
use App\Trait\EmailEntityTrait;
use App\Trait\IdEntityTrait;
use App\Trait\IsEnabledEntityTrait;
use App\Trait\NameEntityTrait;
use App\Trait\SurnameEntityTrait;
use App\Trait\TimestampableEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ApiResource(
    operations: [
        new Put(security: 'is_granted("ROLE_ADMIN") or (is_granted("ROLE_USER") and object == user)'),
        new Post(security: 'is_granted("PUBLIC_ACCESS")'),
        new Patch(security: 'is_granted("ROLE_ADMIN") or (is_granted("ROLE_USER") and object == user)'),
        new Delete(security: 'is_granted("ROLE_ADMIN") or (is_granted("ROLE_USER") and object == user)'),
    ],
    security: 'is_granted("ROLE_USER")',
    graphQlOperations: [
        new Query(),
        new Query(
            resolver: MeResolver::class,
            args: [],
            security: 'is_granted("ROLE_USER")',
            securityMessage: 'You are not logged in',
            name: 'me'
        ),
    ]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TimestampableInterface
{
    use EmailEntityTrait;
    use IdEntityTrait;
    use IsEnabledEntityTrait;
    use NameEntityTrait;
    use SurnameEntityTrait;
    use TimestampableEntityTrait;

    /**
     * @var array<int, string>
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Participation::class, orphanRemoval: true)]
    private Collection $participations;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $phone = null;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->getName(), $this->getSurname());
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return array<int, string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<int, string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setUser($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        // set the owning side to null (unless already changed)
        if (!$this->participations->removeElement($participation)) {
            return $this;
        }

        if ($participation->getUser() !== $this) {
            return $this;
        }

        $participation->setUser(null);

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
