<?php

declare(strict_types=1);

namespace App\Application\API\Result;

use App\Domain\Data\Model\FlickrBookmark;

class FlickrBookmarkResult extends BookmarkResult
{
    private int $width;
    private int $height;

    public function __construct(FlickrBookmark $bookmark)
    {
        parent::__construct($bookmark);

        $this->width  = $bookmark->getWidth();
        $this->height = $bookmark->getHeight();
    }

    public function jsonSerialize()
    {
        return parent::jsonSerialize() + [
            'width'  => $this->width,
            'height' => $this->height,
        ];
    }
}
