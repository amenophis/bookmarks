<?php

declare(strict_types=1);

namespace App\Infrastructure\URIMetadata;

use App\Domain\URIMetadata\URIMetadata;
use App\Domain\URIMetadata\URIMetadataReader;

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
