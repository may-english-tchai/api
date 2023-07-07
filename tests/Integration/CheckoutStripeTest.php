<?php

namespace App\Tests\Integration;

use App\Entity\Participation;
use App\Enum\PaymentStatusEnum;
use App\Repository\ParticipationRepository;
use App\Repository\PaymentRepository;
use App\Stripe\CheckoutStripe;
use PHPUnit\Framework\MockObject\Exception;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckoutStripeTest extends KernelTestCase
{
    /**
     * @throws \Exception
     * @throws Exception
     */
    public function testSavePayment(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $checkout = $container->get(CheckoutStripe::class);
        $participation = $container->get(ParticipationRepository::class)->find('9aed42c1-be58-4610-92f5-f8789e35293c');
        static::assertInstanceOf(Participation::class, $participation);

        $session = new Session($id = 'cs_test_a1o8vq5rzW1MNUFLcqKq5EzPxHmqVzQFnwFDrKrZXo0BkGjByqfW84mycn');
        $session->url = 'https://checkout.stripe.com/c/pay/cs_test_a1o8vq5rzW1MNUFLcqKq5EzPxHmqVzQFnwFDrKrZXo0BkGjByqfW84mycn#fidkdWxOYHwnPyd1blpxYHZxWjA0S0tHNGlBPHxhQkhWNGhsRl1pZDJ3UWdEa3FVPDx1dkQwQlNgcmM2M0lgX05xMF98dUc0Ykc8T0w0RjRTYzdzTXx8R2RCN1YydT1JbVZIRGM9XWJhSGBiNTU3SmAyRkwyRycpJ2N3amhWYHdzYHcnP3F3cGApJ2lkfGpwcVF8dWAnPyd2bGtiaWBabHFgaCcpJ2BrZGdpYFVpZGZgbWppYWB3dic%2FcXdwYHgl';
        $session->payment_status = 'unpaid';
        $session->amount_subtotal = (int) ($participation->getAmount() * 100);
        $session->amount_total = $session->amount_subtotal;

        $checkout->savePayment(participation: $participation, checkoutSession: $session);

        $payment = $container->get(PaymentRepository::class)->findOneBy(['reference' => $id]);
        static::assertNotNull($payment);
        static::assertSame($id, $payment->getReference());
        static::assertSame($participation->getAmount(), $payment->getAmount());
        static::assertSame($payment->getStatus(), PaymentStatusEnum::unpaid);
        static::assertNotEmpty($payment->getData());
    }
}
