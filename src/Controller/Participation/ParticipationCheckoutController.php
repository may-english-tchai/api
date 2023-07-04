<?php

namespace App\Controller\Participation;

use App\Entity\Availability;
use App\Entity\Participation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ParticipationCheckoutController extends AbstractController
{
    public function __invoke(
        Availability $availability,
        #[Autowire('%env(string:STRIPE_KEY)%')] string $stripeKey,
        #[Autowire('%env(string:STRIPE_SECRET)%')] string $stripeSecret,
    ): Participation {
        if (!($user = $this->getUser()) instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return new Participation(
            user: $user,
            availability: $availability
        );
    }
}
