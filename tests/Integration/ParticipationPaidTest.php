<?php

namespace App\Tests\Integration;

use App\Entity\Payment;
use App\Enum\PaymentStatusEnum;
use App\Repository\PaymentRepository;
use App\Tests\Api\Trait\GetUserTrait;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParticipationPaidTest extends KernelTestCase
{
    use GetUserTrait;

    /**
     * @throws \Exception
     * @throws Exception
     */
    public function testParticipationAlreadyPaid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $payment = $container->get(PaymentRepository::class)->findOneBy(['status' => PaymentStatusEnum::paid]);
        static::assertInstanceOf(Payment::class, $payment);

        $participation = $payment->getParticipation();
        $newPayments = new Payment();
        $newPayments->setAmount(100);
        $newPayments->setParticipation($participation);
        $newPayments->setStatus(PaymentStatusEnum::prepare);

        $errors = $container->get(ValidatorInterface::class)->validate($newPayments);
        static::assertCount(1, $errors);
    }
}
