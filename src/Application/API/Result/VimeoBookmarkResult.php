<?php

declare(strict_types=1);

namespace App\Application\API\Result;

use App\Domain\Data\Model\VimeoBookmark;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema
 */
class VimeoBookmarkResult extends BookmarkResult
{
    public int $width;
    public int $height;
    public int $duration;

    public function __construct(VimeoBookmark $bookmark)
    {
        parent::__construct($bookmark);

        $this->width    = $bookmark->getWidth();
        $this->height   = $bookmark->getHeight();
        $this->duration = $bookmark->getDuration();
    }
}
