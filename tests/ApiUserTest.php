<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiUserTest extends WebTestCase
{
    public function testForbidenWithoutLogin(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/api/users');

        static::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testCanRegister(): void
    {
        $client = static::createClient();
        $client->jsonRequest(Request::METHOD_POST, '/api/users', [
            'email' => 'test@test.com',
            'name' => 'test',
            'surname' => 'test',
            'password' => 'test',
        ]);

        static::assertResponseIsSuccessful();
    }
}
