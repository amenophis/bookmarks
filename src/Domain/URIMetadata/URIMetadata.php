<?php

declare(strict_types=1);

namespace App\Domain\URIMetadata;

class URIMetadata
{
    /**
     * @var array<string|int>
     */
    private array $metadata;

    /**
     * @param array<string|int> $metadata
     */
    public function __construct(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return int|string|null
     */
    public function get(string $metadata)
    {
        return $this->metadata[$metadata] ?? null;
    }
}
