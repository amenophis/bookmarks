<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\URIMetadata\URIMetadata;

class FlickrBookmark extends Bookmark
{
    private int $width;
    private int $height;

    public static function create(string $url, \DateTimeInterface $addedAt, ?URIMetadata $metadata = null): self
    {
        $self         = new self($url, $addedAt, $metadata);
        $self->width  = (int) $metadata->get('width');
        $self->height = (int) $metadata->get('height');

        return $self;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
