<?php

namespace App\Tests\Api\Participation;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Availability;
use App\Entity\Payment;
use App\Enum\PaymentStatusEnum;
use App\Repository\AvailabilityRepository;
use App\Repository\PaymentRepository;
use App\Tests\Api\Trait\GetUserTrait;
use Exception;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ParticipationCheckoutTest extends ApiTestCase
{
    use GetUserTrait;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testNotFoundAvailability(): void
    {
        $uuid = Uuid::v4();
        static::createClient()->request(Request::METHOD_POST, '/api/participations/checkout/'.$uuid);
        static::assertResponseStatusCodeSame(404);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function testUnauthorizedWithoutCredential(): void
    {
        $availability = static::getContainer()->get(AvailabilityRepository::class)->find('43b9bee6-8b59-4c64-9113-80bf4a7356c0');
        static::assertInstanceOf(Availability::class, $availability);
        static::createClient()->request(Request::METHOD_POST, '/api/participations/checkout/'.$availability->getId());
        static::assertResponseStatusCodeSame(401);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function testUnauthorizedWithoutReferer(): void
    {
        $availability = static::getContainer()->get(AvailabilityRepository::class)->find('43b9bee6-8b59-4c64-9113-80bf4a7356c0');
        static::assertInstanceOf(Availability::class, $availability);
        static::createClient()->loginUser(static::getUser('ahmed@gmail.com'))
            ->request(Request::METHOD_POST, '/api/participations/checkout/'.$availability->getId());
        static::assertResponseStatusCodeSame(400);
    }

    /**
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    #[Test]
    public function cannotPayParticipationAlreadyPaid(): void
    {
        $payment = self::getContainer()->get(PaymentRepository::class)->findOneBy(['status' => PaymentStatusEnum::paid]);
        static::assertInstanceOf(Payment::class, $payment);

        $availability = $payment->getParticipation()?->getAvailability();
        static::assertInstanceOf(Availability::class, $availability);

        $user = $payment->getParticipation()?->getUser();
        static::assertNotNull($user);

        $client = static::createClient()
            ->loginUser($user)
            ->request(Request::METHOD_POST, '/api/participations/checkout/'.$availability->getId(), [
                'headers' => [
                    'referer' => 'http://localhost',
                ],
            ]);

        static::expectException(ClientExceptionInterface::class);
        static::assertResponseStatusCodeSame(400);
        self::assertStringContainsString('Participation already paid', $client->getContent());
    }
}
