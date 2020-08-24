<?php

declare(strict_types=1);

namespace App\Application\API\Result;

use App\Domain\Data\Model\FlickrBookmark;

class FlickrBookmarkResult extends BookmarkResult
{
    public int $width;
    public int $height;

    public function __construct(FlickrBookmark $bookmark)
    {
        parent::__construct($bookmark);

        $this->width  = $bookmark->getWidth();
        $this->height = $bookmark->getHeight();
    }
}
