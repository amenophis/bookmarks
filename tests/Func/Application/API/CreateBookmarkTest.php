<?php

declare(strict_types=1);

namespace Func\App\Application\API;

use App\Domain\URIMetadata\URIMetadata;
use App\Infrastructure\FakeIdGenerator;
use App\Infrastructure\URIMetadata\TestReader;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Func\App\FunctionalTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class CreateBookmarkTest extends FunctionalTestCase
{
    use PHPMatcherAssertions;
    use RefreshDatabaseTrait;

    /**
     * @dataProvider provideCreateValidationErrors
     */
    public function testCreateValidationErrors(array $payload, array $errors): void
    {
        $this->postJson('/bookmarks', $payload);

        $this->assertBadRequestResponse($errors);
    }

    public function provideCreateValidationErrors(): \Generator
    {
        yield [
            [],
            [
                'violations' => [
                    [
                        'message'      => 'This value should not be blank.',
                        'propertyPath' => 'url',
                    ],
                ],
            ],
        ];

        yield [
            [
                'url' => 123,
            ],
            [
                'violations' => [
                    [
                        'message'      => 'This value is not a valid URL.',
                        'propertyPath' => 'url',
                    ],
                ],
            ],
        ];

        yield [
            [
                'url' => 'bonjour',
            ],
            [
                'violations' => [
                    [
                        'message'      => 'This value is not a valid URL.',
                        'propertyPath' => 'url',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideCreateSuccess
     */
    public function testCreateSuccess(string $uuid, array $payload, array $responsePattern, URIMetadata $metadata): void
    {
        TestReader::setMetadata($metadata);
        FakeIdGenerator::setUuid($uuid);

        $this->backToTheFuture('2020-08-04 17:37:21');

        $this->postJson('/bookmarks', $payload);

        $this->assertCreatedResponse();
        $this->assertJsonResponse();
        $this->assertMatchesPattern($responsePattern, $this->getResponseAsJsonDecode());
    }

    public function provideCreateSuccess(): \Generator
    {
        yield 'vimeo url' => [
            $id = 'ffdc3612-bf52-46b5-ba7e-4102ac68d04f',
            [
                'url' => $url = 'https://vimeo.com/437769507',
            ],
            [
                'id'       => $id,
                'url'      => $url,
                'title'    => 'La Voiture',
                'author'   => 'Gary Bird',
                'addedAt'  => '2020-08-04T17:37:21+00:00',
                'width'    => 426,
                'height'   => 240,
                'duration' => 22,
                'keywords' => [],
            ],
            new URIMetadata([
                'provider_name' => 'Vimeo',
                'title'         => 'La Voiture',
                'author'        => 'Gary Bird',
                'width'         => 426,
                'height'        => 240,
                'duration'      => 22,
            ]),
        ];

        yield 'flickr url' => [
            $id = 'c1792db0-b20c-44b5-af03-7705fff21c66',
            [
                'url' => $url = 'https://www.flickr.com/photos/151833726@N07/27282432957/in/photolist-HyRAP8-2e6gHjv-pNzxW-21Um94b-A9UPiB-KHxzmR-LC9e2D-2btUunU-22TEnSo-VrJwwq-6oPnsK-2eNPx2y-4ZMpkL-T6mnJX-2aMrhxp-YUnBaT-YBGtN3-ebToY5-Vr5Lao-2cPKFrQ-5Mk7k4-QYZQTJ-LhZrN3-UPsF2E-26jpr1s-cRCzaq-Gkd6yQ-xsxqcg-8TS7cR-23mFJUG-MZvKuR-HwsTvF-28MNU9G-DHKC3M-NLRGpG-a7wXWk-H2zAui-PAP6Ts-25w9SvZ-HU8H97-25GFULP-PVqU3r-xD3NuJ-EZfTNw-Str1pq-eUwDJ-jsP9Yd-24TgTFy-Amw8de-V4TSj8',
            ],
            [
                'id'       => $id,
                'url'      => $url,
                'title'    => 'Jaguar, voiture de prestige.',
                'author'   => 'Un jour en France',
                'addedAt'  => '2020-08-04T17:37:21+00:00',
                'width'    => 1024,
                'height'   => 576,
                'keywords' => [],
            ],
            new URIMetadata([
                'provider_name' => 'Flickr',
                'title'         => 'Jaguar, voiture de prestige.',
                'author'        => 'Un jour en France',
                'width'         => 1024,
                'height'        => 576,
            ]),
        ];
    }
}
