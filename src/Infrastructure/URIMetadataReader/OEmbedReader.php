<?php

declare(strict_types=1);

namespace App\Infrastructure\URIMetadataReader;

use App\Domain\URIMetadataReader\URIMetadata;
use App\Domain\URIMetadataReader\URIMetadataReader;
use Embed\Embed;

class OEmbedReader implements URIMetadataReader
{
    public function read(string $url): URIMetadata
    {
        $embed = new Embed();

        $info = $embed->get($url)->getOEmbed();

        return new URIMetadata(
            $info->all()
        );
    }
}
