<?php

declare(strict_types=1);

namespace App\Application\API\Action\ListBookmarks;

use App\Application\API\Action\ListBookmarks\Result\FlickrBookmarkResult;
use App\Application\API\Action\ListBookmarks\Result\VimeoBookmarkResult;
use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Model\FlickrBookmark;
use App\Domain\Data\Model\VimeoBookmark;

class ResultFactory
{
    /**
     * @param Bookmark[] $bookmarks
     */
    public function createResultFromBookmark(array $bookmarks): Result
    {
        $bookmarkResults = [];
        foreach ($bookmarks as $bookmark) {
            switch (true) {
                case $bookmark instanceof FlickrBookmark:
                    $bookmarkResults[] = new FlickrBookmarkResult(
                        $bookmark->getId(),
                        $bookmark->getUrl(),
                        $bookmark->getTitle(),
                        $bookmark->getAuthor(),
                        $bookmark->getAddedAt(),
                        $bookmark->getWidth(),
                        $bookmark->getHeight(),
                    );
                    break;
                case $bookmark instanceof VimeoBookmark:
                    $bookmarkResults[] = new VimeoBookmarkResult(
                        $bookmark->getId(),
                        $bookmark->getUrl(),
                        $bookmark->getTitle(),
                        $bookmark->getAuthor(),
                        $bookmark->getAddedAt(),
                        $bookmark->getWidth(),
                        $bookmark->getHeight(),
                        $bookmark->getDuration(),
                    );
                    break;
                default:
                    $bookmarkClass = \get_class($bookmark);
                    throw new \LogicException("Result for {$bookmarkClass} must be created");
            }
        }

        return new Result($bookmarkResults);
    }
}
