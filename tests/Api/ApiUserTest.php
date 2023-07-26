<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ApiUserTest extends WebTestCase
{
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
