<?php

declare(strict_types=1);

namespace App\Infrastructure\URIMetadataReader;

use App\Domain\URIMetadataReader\URIMetadata;
use App\Domain\URIMetadataReader\URIMetadataReader;

class TestReader implements URIMetadataReader
{
    private static URIMetadata $metadata;

    public static function setMetadata(URIMetadata $metadata): void
    {
        static::$metadata = $metadata;
    }

    public function read(string $url): URIMetadata
    {
        return static::$metadata;
    }
}
