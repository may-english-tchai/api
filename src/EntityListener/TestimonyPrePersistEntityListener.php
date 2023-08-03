<?php

namespace App\EntityListener;

use App\Entity\Testimony;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsEntityListener(event: Events::prePersist, entity: Testimony::class)]
final readonly class TestimonyPrePersistEntityListener
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function __invoke(Testimony $testimony): void
    {
        $user = $this->security->getUser();

        if ($user instanceof User && !$testimony->getFromUser() instanceof User) {
            $testimony->setFromUser($user);
        }

        if ($testimony->getFromUser() instanceof User) {
            $testimony->setName((string) $testimony->getFromUser()->getName());
        }
    }
}
