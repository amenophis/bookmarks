<?php

declare(strict_types=1);

namespace App\Application\API\Result;

use App\Domain\Data\Model\VimeoBookmark;

class VimeoBookmarkResult extends BookmarkResult
{
    private int $width;
    private int $height;
    private int $duration;

    public function __construct(VimeoBookmark $bookmark)
    {
        parent::__construct($bookmark);

        $this->width    = $bookmark->getWidth();
        $this->height   = $bookmark->getHeight();
        $this->duration = $bookmark->getDuration();
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
