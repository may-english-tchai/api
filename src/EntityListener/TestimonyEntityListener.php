<?php

namespace App\EntityListener;

use App\Entity\Testimony;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Symfony\Bundle\SecurityBundle\Security;

#[AsEntityListener(event: 'prePersist', method: 'prePersist', entity: Testimony::class)]
final readonly class TestimonyEntityListener
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function prePersist(Testimony $testimony): void
    {
        $user = $this->security->getUser();

        if ($user instanceof User && !$testimony->getFromUser() instanceof \App\Entity\User) {
            $testimony->setFromUser($user);
        }

        if ($testimony->getFromUser() instanceof \App\Entity\User) {
            $testimony->setName((string) $testimony->getFromUser()->getName());
        }
    }
}
