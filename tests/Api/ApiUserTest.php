<?php

namespace App\Tests\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

use const JSON_THROW_ON_ERROR;

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

    /**
     * @throws Exception
     */
    public function testGetMeUserWithoutCredential(): void
    {
        $client = static::createClient();
        $client->jsonRequest(Request::METHOD_POST, '/api/graphql', [
            'query' => 'query {
                meUser { id }
            }',
        ]);
        static::assertResponseIsSuccessful();
        self::assertStringContainsString('You are not logged in', (string) $client->getResponse()->getContent());
    }

    /**
     * @throws Exception
     */
    public function testGetMeUser(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneBy(['email' => 'abdou@gmail.com']);
        static::assertInstanceOf(User::class, $user);
        $client->loginUser($user);
        $client->jsonRequest(Request::METHOD_POST, '/api/graphql', [
            'query' => 'query {
                meUser {
                    id
                    email
                    name
                    surname
                    participations { edges{ node { id } } }
                }
            }',
        ]);

        static::assertResponseIsSuccessful();
        $userResponse = ((object) json_decode((string) $client->getResponse()->getContent(), flags: JSON_THROW_ON_ERROR))->data->meUser;
        self::assertNotNull($user->getId());
        self::assertStringContainsString($user->getId(), $userResponse->id);
        self::assertSame($user->getEmail(), $userResponse->email);
        self::assertSame($user->getName(), $userResponse->name);
        self::assertSame($user->getSurname(), $userResponse->surname);
        self::assertIsArray($userResponse->participations->edges);
        self::assertCount(3, $userResponse->participations->edges);
    }
}
