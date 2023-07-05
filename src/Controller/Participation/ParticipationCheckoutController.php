<?php

namespace App\Controller\Participation;

use App\Entity\Availability;
use App\Entity\User;
use App\Exception\UnexpectedValueException;
use App\Stripe\CheckoutStripe;
use Stripe\Exception\ApiErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
class ParticipationCheckoutController extends AbstractController
{
    /**
     * @throws ApiErrorException
     * @throws UnexpectedValueException
     */
    #[Route('/api/participations/checkout/{id}', name: 'api_participation_checkout', methods: [Request::METHOD_POST])]
    #[IsGranted('ROLE_USER')]
    public function __invoke(
        Request $request,
        Availability $availability,
        CheckoutStripe $checkoutStripe,
    ): JsonResponse {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        if (!$request->headers->has('referer')) {
            throw new UnexpectedValueException(statusCode: Response::HTTP_BAD_REQUEST, message: 'Referer is null');
        }

        $referer = (string) $request->headers->get('referer');

        $session = $checkoutStripe($availability, $referer, $user);

        return $this->json($session);
    }
}
