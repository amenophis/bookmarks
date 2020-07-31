<?php

declare(strict_types=1);

namespace App\Application\API\Action\CreateBookmark\Result;

class VimeoResult extends Result
{
    private int $width;
    private int $height;
    private int $duration;

    public function __construct(int $id, string $url, ?string $title, ?string $author, \DateTimeInterface $addedAt, int $width, int $height, int $duration)
    {
        parent::__construct($id, $url, $title, $author, $addedAt);

        $this->width    = $width;
        $this->height   = $height;
        $this->duration = $duration;
    }

    public function jsonSerialize()
    {
        return parent::jsonSerialize() + [
            'width'    => $this->width,
            'height'   => $this->height,
            'duration' => $this->duration,
        ];
    }
}
