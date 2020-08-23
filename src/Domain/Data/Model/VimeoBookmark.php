<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\URIMetadata\URIMetadata;

class VimeoBookmark extends Bookmark
{
    private int $width;
    private int $height;
    private int $duration;

    public static function create(BookmarkId $id, string $url, \DateTimeInterface $addedAt, URIMetadata $metadata): self
    {
        $self           = new self($id, $url, $addedAt, $metadata);
        $self->width    = (int) $metadata->get('width');
        $self->height   = (int) $metadata->get('height');
        $self->duration = (int) $metadata->get('duration');

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

    public function getDuration(): int
    {
        return $this->duration;
    }
}
