<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Availability;
use App\Repository\AvailabilityRepository;
use App\Tests\Api\Trait\GetUserTrait;
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
     */
    public function testUnauthorizedWithoutReferer(): void
    {
        $availability = static::getContainer()->get(AvailabilityRepository::class)->find('43b9bee6-8b59-4c64-9113-80bf4a7356c0');
        static::assertInstanceOf(Availability::class, $availability);
        // $this->expectException(ClientExceptionInterface::class);
        static::createClient()->loginUser(static::getUser('ahmed@gmail.com'))
            ->request(Request::METHOD_POST, '/api/participations/checkout/'.$availability->getId());
        static::assertResponseStatusCodeSame(400);
    }
}
