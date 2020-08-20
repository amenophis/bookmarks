<?php

declare(strict_types=1);

namespace Func\App\Application\API;

use App\Domain\URIMetadata\URIMetadata;
use App\Infrastructure\URIMetadata\TestReader;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Func\App\FunctionalTestCase;

class BookmarkListTest extends FunctionalTestCase
{
    use PHPMatcherAssertions;

    public function testList(): void
    {
        $this->getJson('/bookmarks');

        $this->assertOKResponse();

        $this->assertMatchesPattern([
            [
                'id'       => '@integer@',
                'url'      => 'https://vimeo.com/437769507',
                'title'    => 'La Voiture',
                'author'   => 'Gary Bird',
                'addedAt'  => '2020-08-04T17:37:21+00:00',
                'width'    => 426,
                'height'   => 240,
                'duration' => 22,
            ],
            [
                'id'      => '@integer@',
                'url'     => 'https://www.flickr.com/photos/151833726@N07/27282432957/in/photolist-HyRAP8-2e6gHjv-pNzxW-21Um94b-A9UPiB-KHxzmR-LC9e2D-2btUunU-22TEnSo-VrJwwq-6oPnsK-2eNPx2y-4ZMpkL-T6mnJX-2aMrhxp-YUnBaT-YBGtN3-ebToY5-Vr5Lao-2cPKFrQ-5Mk7k4-QYZQTJ-LhZrN3-UPsF2E-26jpr1s-cRCzaq-Gkd6yQ-xsxqcg-8TS7cR-23mFJUG-MZvKuR-HwsTvF-28MNU9G-DHKC3M-NLRGpG-a7wXWk-H2zAui-PAP6Ts-25w9SvZ-HU8H97-25GFULP-PVqU3r-xD3NuJ-EZfTNw-Str1pq-eUwDJ-jsP9Yd-24TgTFy-Amw8de-V4TSj8',
                'title'   => 'Jaguar, voiture de prestige.',
                'author'  => 'Un jour en France',
                'addedAt' => '2020-08-04T17:37:21+00:00',
                'width'   => 1024,
                'height'  => 576,
            ],
        ], $this->getResponseAsJsonDecode());
    }
}
