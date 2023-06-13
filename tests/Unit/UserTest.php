<?php

namespace App\Tests\Unit;

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
        $user = new User();
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        static::assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }
}
