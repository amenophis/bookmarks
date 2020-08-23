<?php

declare(strict_types=1);

namespace App\Application\API\Result;

use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Model\FlickrBookmark;
use App\Domain\Data\Model\VimeoBookmark;

class ResultFactory
{
    public function createResultFromBookmark(Bookmark $bookmark): BookmarkResult
    {
        switch (true) {
            case $bookmark instanceof FlickrBookmark:
                return new FlickrBookmarkResult($bookmark);
            case $bookmark instanceof VimeoBookmark:
                return new VimeoBookmarkResult($bookmark);
            default:
                $bookmarkClass = \get_class($bookmark);
                throw new \LogicException("Result for {$bookmarkClass} must be created");
        }
    }
}
