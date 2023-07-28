<?php

namespace App\Stripe;

use App\Dto\CheckoutStripeDto;
use App\Entity\Availability;
use App\Entity\Participation;
use App\Entity\Payment;
use App\Entity\User;
use App\Enum\PaymentStatusEnum;
use App\Repository\ParticipationRepository;
use App\Repository\PaymentRepository;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CheckoutStripe
{
    public function __construct(
        private PaymentRepository $paymentRepository,
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
        $payment = $this->preparePayment($user, $availability);

        Stripe::setApiKey($this->stripeSecret);
        $checkoutSession = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount_decimal' => $payment->getAmount() * 100,
                    'product_data' => [
                        'name' => (string) $availability,
                        'metadata' => [
                            'availability_id' => $availability->getId(),
                            'participation_id' => $payment->getParticipation()?->getId(),
                            'payment_id' => $payment->getId(),
                        ],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => Session::MODE_PAYMENT,
            'success_url' => sprintf('%s/payment-success?id=%s', $referer, $payment->getId()),
            'cancel_url' => sprintf('%s/payment-canceled?id=%s', $referer, $payment->getId()),
        ]);

        $this->saveCheckoutPayment($payment, $checkoutSession);

        return new CheckoutStripeDto(
            sessionId: $checkoutSession->id,
            paymentId: $payment->getId(),
            url: $checkoutSession->url,
        );
    }

    public function preparePayment(User $user, Availability $availability): Payment
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

        $payment = (new Payment())
            ->setParticipation($participation)
            ->setAmount($participation->getAmount())
            ->setStatus(PaymentStatusEnum::prepare)
        ;

        $this->paymentRepository->save($payment, true);

        return $payment;
    }

    public function saveCheckoutPayment(Payment $payment, Session $checkoutSession): Payment
    {
        $payment->setReference($checkoutSession->id)
            ->setData($checkoutSession->toArray())
            ->setStatus(PaymentStatusEnum::from($checkoutSession->payment_status))
        ;

        $this->paymentRepository->save($payment, true);

        return $payment;
    }
}
