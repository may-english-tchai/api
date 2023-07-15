<?php

namespace App\Stripe;

use App\Entity\Payment;
use App\Enum\PaymentStatusEnum;
use App\Exception\UnexpectedResultException;
use App\Repository\PaymentRepository;
use Stripe\Event;

readonly class CheckoutEventStripe
{
    public function __construct(
        private PaymentRepository $paymentRepository
    ) {
    }

    /**
     * @throws UnexpectedResultException
     */
    public function __invoke(Event $event): Payment
    {
        /** @var object{object: object{ id: string, payment_status: string}} $data */
        $data = $event->data;
        $reference = $data->object->id;
        $payment = $this->paymentRepository->findOneBy(['reference' => $reference]);
        if (!$payment instanceof Payment) {
            throw new UnexpectedResultException('not found payment with reference '.$reference);
        }

        $status = PaymentStatusEnum::from($data->object->payment_status);

        $payment->setStatus($status);
        $this->paymentRepository->save($payment, true);

        return $payment;
    }
}
