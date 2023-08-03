<?php

namespace App\Tests\Integration\Repository;

use App\Repository\UserRepository;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    #[Test]
    public function findByRoles(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $users = $container->get(UserRepository::class)
            ->findUserByRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        static::assertCount(4, $users);
    }
}
