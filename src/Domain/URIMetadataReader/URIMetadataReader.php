<?php

declare(strict_types=1);

namespace App\Domain\URIMetadataReader;

interface URIMetadataReader
{
    public function read(string $url): URIMetadata;
}
