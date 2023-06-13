<?php

namespace App\Tests\Unit;

use App\Entity\User;
use App\EntityListener\UserEntityListener;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEntityListenerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testNeedReHash(): void
    {
        $hashMock = $this->createMock(UserPasswordHasherInterface::class);
        $user = new User();
        $user->setPassword('password');

        $hashMock->expects(static::once())
            ->method('needsRehash')
            ->with($user)
            ->willReturn(true);

        $hashMock->expects(static::once())
            ->method('hashPassword')
            ->with($user, 'password')
            ->willReturn('hashedPassword');

        $entityListener = new UserEntityListener($hashMock);
        $entityListener->prePersist($user);

        static::assertSame('hashedPassword', $user->getPassword());
    }
}
