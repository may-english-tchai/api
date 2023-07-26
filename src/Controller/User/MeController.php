<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Exception\UnexpectedResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class MeController extends AbstractController
{
    /**
     * @throws UnexpectedResultException
     */
    public function __invoke(Security $security): User
    {/** @var User $user */
        $user = $security->getUser();
        if (!$user->isEnabled()) {
            throw new UnexpectedResultException('User is not enabled');
        }

        return $user;
    }
}
