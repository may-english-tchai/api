<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\TestimonyRepository;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TestimonyApiTest extends ApiTestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testTestimoniesUrl(): void
    {
        static::createClient()->request('GET', '/api/testimonies');

        static::assertResponseIsSuccessful();
        static::assertJsonContains(['@id' => '/api/testimonies']);
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws Exception
     */
    public function testTestimonies(): void
    {
        static::createClient()->request('GET', '/api/testimonies');

        $count = static::getContainer()->get(TestimonyRepository::class)->count([]);

        static::assertResponseIsSuccessful();
        static::assertJsonContains(['hydra:totalItems' => $count]);
    }
}
