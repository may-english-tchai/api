<?php

namespace App\Tests\Api\Trait;

use App\Entity\User;
use App\Repository\UserRepository;

trait GetUserTrait
{
    public function getUser(string $email): User
    {
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => $email]);
        assert($user instanceof User);

        return $user;
    }
}
