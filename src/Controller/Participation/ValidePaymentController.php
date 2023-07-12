<?php

namespace App\Controller\Participation;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidePaymentController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route('/api/participations/valide-payment', name: 'api_participation_valide_payment')]
    public function __invoke(Request $request): Response
    {
        $this->logger->debug(__FUNCTION__, ['content' => $request->getContent()]);

        return $this->json([]);
    }
}
