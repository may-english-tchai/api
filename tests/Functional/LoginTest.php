<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class LoginTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        $client->jsonRequest(Request::METHOD_POST, '/api/login', [
            'email' => 'mkl.devops@gmail.com',
            'password' => 'test',
        ]);

        static::assertResponseIsSuccessful();
    }
}
