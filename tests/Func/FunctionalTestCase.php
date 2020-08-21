<?php

declare(strict_types=1);

namespace Func\App;

use Cake\Chronos\Chronos;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class FunctionalTestCase extends WebTestCase
{
    /**
     * @var KernelBrowser|mixed
     */
    protected static $client;

    protected function setUp(): void
    {
        parent::setUp();

        static::$client = static::createClient();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        static::$client = null;
        Chronos::setTestNow();
    }

    protected function backToTheFuture(string $date): void
    {
        Chronos::setTestNow($date);
    }

    protected function getJson(string $url, array $parameters = []): void
    {
        self::$client->request(
            'GET',
            $url,
            $parameters,
            [],
            [
                'ACCEPT' => 'application/json',
            ]
        );

        $this->assertJsonResponse();
    }

    protected function postJson(string $url, array $payload = [], array $parameters = []): void
    {
        self::$client->request(
            'POST',
            $url,
            $parameters,
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'ACCEPT'       => 'application/json',
            ],
            json_encode($payload)
        );

        $this->assertJsonResponse();
    }

    protected function delete(string $url): void
    {
        self::$client->request(
            'DELETE',
            $url,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'ACCEPT'       => 'application/json',
            ],
        );
    }

    protected static function getResponse(): Response
    {
        return static::$client->getResponse();
    }

    protected function getResponseContent(): string
    {
        $content = static::getResponse()->getContent();

        if (false === $content) {
            $this->fail('No response content');
        }

        return $content;
    }

    protected function getResponseAsJsonDecode()
    {
        return json_decode($this->getResponseContent(), true);
    }

    protected function assertJsonResponse(): void
    {
        $this->assertSame('application/json', static::getResponse()->headers->get('Content-Type'));
    }

    protected function assertNotFoundResponse(): void
    {
        static::assertResponseStatusCodeSame(404);
    }

    protected function assertOKResponse(): void
    {
        static::assertResponseStatusCodeSame(200);
    }

    protected function assertCreatedResponse(): void
    {
        static::assertResponseStatusCodeSame(201);
    }

    protected function assertEmptyResponse(): void
    {
        static::assertResponseStatusCodeSame(204);
        $this->assertSame('', $this->getResponseContent());
    }

    protected function assertBadRequestResponse(array $expectedResponse): void
    {
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedResponse),
            $this->getResponseContent()
        );
    }
}
