<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\URIMetadata\URIMetadata;

class FlickrBookmark extends Bookmark
{
    private int $width;
    private int $height;

    public static function create(BookmarkId $id, string $url, \DateTimeInterface $addedAt, URIMetadata $metadata): self
    {
        $self         = new self($id, $url, $addedAt, $metadata);
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
