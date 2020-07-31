<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\URIMetadataReader\URIMetadata;

abstract class Bookmark
{
    private int $id;
    private string $url;
    private ?string $title;
    private ?string $author;
    private \DateTimeInterface $addedAt;

    protected function __construct(string $url, \DateTimeInterface $addedAt, URIMetadata $metadata)
    {
        $this->url     = $url;
        $this->title   = (string) $metadata->get('title');
        $this->author  = (string) $metadata->get('author');
        $this->addedAt = $addedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getAddedAt(): \DateTimeInterface
    {
        return $this->addedAt;
    }
}
