<?php

namespace App\Resolver\User;

use ApiPlatform\GraphQl\Resolver\QueryItemResolverInterface;
use App\Entity\User;
use App\Exception\UnexpectedResultException;
use Symfony\Bundle\SecurityBundle\Security;

readonly class MeResolver implements QueryItemResolverInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    /**
     * @phpstan-param string[] $context
     *
     * @throws UnexpectedResultException
     *
     * @phpstan-ignore-next-line
     */
    public function __invoke(?object $item, array $context): User
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new UnexpectedResultException('You are not logged in');
        }

        if (!$user->isEnabled()) {
            throw new UnexpectedResultException('User is not enabled');
        }

        return $user;
    }
}
