<?php

declare(strict_types=1);

namespace Func\App\Application\API;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Func\App\FunctionalTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class ListBookmarkTest extends FunctionalTestCase
{
    use PHPMatcherAssertions;
    use RefreshDatabaseTrait;

    public function testList(): void
    {
        $this->getJson('/bookmarks');

        $this->assertOKResponse();
        $this->assertJsonResponse();
        $this->assertMatchesPattern([
            [
                'id'       => 'b841b091-8377-4dcd-a3f2-37a642920d84',
                'url'      => 'https://vimeo.com/437769507',
                'title'    => 'La Voiture',
                'author'   => 'Gary Bird',
                'addedAt'  => '@string@.isDateTime()',
                'width'    => 426,
                'height'   => 240,
                'duration' => 22,
                'keywords' => ['Voiture'],
            ],
            [
                'id'       => 'c47f0bae-49a6-4b66-8504-e55d03dc3f09',
                'url'      => 'https://www.flickr.com/photos/151833726@N07/27282432957/in/photolist-HyRAP8-2e6gHjv-pNzxW-21Um94b-A9UPiB-KHxzmR-LC9e2D-2btUunU-22TEnSo-VrJwwq-6oPnsK-2eNPx2y-4ZMpkL-T6mnJX-2aMrhxp-YUnBaT-YBGtN3-ebToY5-Vr5Lao-2cPKFrQ-5Mk7k4-QYZQTJ-LhZrN3-UPsF2E-26jpr1s-cRCzaq-Gkd6yQ-xsxqcg-8TS7cR-23mFJUG-MZvKuR-HwsTvF-28MNU9G-DHKC3M-NLRGpG-a7wXWk-H2zAui-PAP6Ts-25w9SvZ-HU8H97-25GFULP-PVqU3r-xD3NuJ-EZfTNw-Str1pq-eUwDJ-jsP9Yd-24TgTFy-Amw8de-V4TSj8',
                'title'    => 'Jaguar, voiture de prestige.',
                'author'   => 'Un jour en France',
                'addedAt'  => '@string@.isDateTime()',
                'width'    => 1024,
                'height'   => 576,
                'keywords' => ['Voiture'],
            ],
        ], $this->getResponseAsJsonDecode());
    }
}
