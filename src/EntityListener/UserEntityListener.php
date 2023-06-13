<?php

namespace App\EntityListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: 'prePersist', method: 'prePersist', entity: User::class)]
final readonly class UserEntityListener
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function prePersist(User $user): void
    {
        if (null === $user->getPassword()) {
            return;
        }

        if ($this->passwordHasher->needsRehash($user)) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        }
    }
}
