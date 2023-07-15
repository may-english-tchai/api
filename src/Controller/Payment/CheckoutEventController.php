<?php

namespace App\Controller\Payment;

use App\Exception\UnexpectedResultException;
use App\Stripe\CheckoutEventStripe;
use Stripe\Event;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutEventController extends AbstractController
{
    /**
     * @throws UnexpectedResultException
     */
    #[Route('/api/payment/checkout-event', name: 'api_participation_checkout_event', methods: [Request::METHOD_POST])]
    public function __invoke(
        Request $request,
        CheckoutEventStripe $checkoutEventStripe,
        #[Autowire('%env(string:STRIPE_SECRET)%')]
        string $stripeSecret,
    ): Response {
        Stripe::setApiKey($stripeSecret);
        $event = Event::constructFrom($request->toArray());

        return $this->json($checkoutEventStripe($event));
    }
}
