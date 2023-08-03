<?php

namespace App\Tests\Unit;

use App\Entity\Role;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetUserIdentifierIsString(): void
    {
        $user = new User();

        static::assertEquals('', $user->getUserIdentifier());
    }

    public function testGetRoles(): void
    {
        $roles = [
            (new Role())->setCode('ROLE_ADMIN'),
            (new Role())->setCode('ROLE_USER'),
        ];
        $user = new User();
        $user->setRoles($roles);

        static::assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }
}
