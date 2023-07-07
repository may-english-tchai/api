<?php

namespace App\Stripe;

use App\Dto\CheckoutStripeDto;
use App\Entity\Availability;
use App\Entity\Participation;
use App\Entity\Payment;
use App\Entity\User;
use App\Enum\PaymentStatusEnum;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CheckoutStripe
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ParticipationRepository $participationRepository,
        #[Autowire('%env(string:STRIPE_SECRET)%')]
        private string $stripeSecret,
    ) {
    }

    /**
     * @throws ApiErrorException
     */
    public function __invoke(Availability $availability, string $referer, User $user): CheckoutStripeDto
    {
        $participation = $this->getParticipation($user, $availability);

        Stripe::setApiKey($this->stripeSecret);
        $checkoutSession = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount_decimal' => $participation->getAmount() * 100,
                    'product_data' => [
                        'name' => (string) $availability,
                        'metadata' => [
                            'availability_id' => $availability->getId(),
                            'participation_id' => $participation->getId(),
                        ],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $referer.'?success=true',
            'cancel_url' => $referer.'?canceled=true',
        ]);

        $this->savePayment($participation, $checkoutSession);

        return new CheckoutStripeDto(
            sessionId: $checkoutSession->id,
            url: $checkoutSession->url,
        );
    }

    public function getParticipation(User $user, Availability $availability): Participation
    {
        $participation = $this->participationRepository->findOneBy([
            'user' => $user,
            'availability' => $availability,
        ]);

        if (!$participation instanceof Participation) {
            $participation = new Participation(
                user: $user,
                availability: $availability
            );

            $this->participationRepository->save($participation, true);
        }

        return $participation;
    }

    public function savePayment(Participation $participation, Session $checkoutSession): Payment
    {
        dump($checkoutSession->id);
        $payment = new Payment();
        $payment->setParticipation($participation)
            ->setAmount($participation->getAmount())
            ->setReference($checkoutSession->id)
            ->setData($checkoutSession->toArray())
            ->setStatus(PaymentStatusEnum::from($checkoutSession->payment_status))
        ;

        $this->entityManager->persist($payment);
        $this->entityManager->flush();

        return $payment;
    }
}
