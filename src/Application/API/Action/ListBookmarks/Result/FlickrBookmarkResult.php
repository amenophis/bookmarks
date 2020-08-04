<?php

declare(strict_types=1);

namespace App\Application\API\Action\ListBookmarks\Result;

class FlickrBookmarkResult extends BookmarkResult
{
    private int $width;
    private int $height;

    public function __construct(int $id, string $url, ?string $title, ?string $author, \DateTimeInterface $addedAt, int $width, int $height)
    {
        parent::__construct($id, $url, $title, $author, $addedAt);

        $this->width  = $width;
        $this->height = $height;
    }

    public function jsonSerialize()
    {
        return parent::jsonSerialize() + [
            'width'  => $this->width,
            'height' => $this->height,
        ];
    }
}
