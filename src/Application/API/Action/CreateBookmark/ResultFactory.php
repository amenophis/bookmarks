<?php

declare(strict_types=1);

namespace App\Application\API\Action\CreateBookmark;

use App\Application\API\Action\CreateBookmark\Result\FlickrResult;
use App\Application\API\Action\CreateBookmark\Result\Result;
use App\Application\API\Action\CreateBookmark\Result\VimeoResult;
use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Model\FlickrBookmark;
use App\Domain\Data\Model\VimeoBookmark;

class ResultFactory
{
    public function createResultFromBookmark(Bookmark $bookmark): Result
    {
        switch (true) {
            case $bookmark instanceof FlickrBookmark:
                return new FlickrResult(
                    $bookmark->getId(),
                    $bookmark->getUrl(),
                    $bookmark->getTitle(),
                    $bookmark->getAuthor(),
                    $bookmark->getAddedAt(),
                    $bookmark->getWidth(),
                    $bookmark->getHeight(),
                );
            case $bookmark instanceof VimeoBookmark:
                return new VimeoResult(
                    $bookmark->getId(),
                    $bookmark->getUrl(),
                    $bookmark->getTitle(),
                    $bookmark->getAuthor(),
                    $bookmark->getAddedAt(),
                    $bookmark->getWidth(),
                    $bookmark->getHeight(),
                    $bookmark->getDuration(),
                );
            default:
                $bookmarkClass = \get_class($bookmark);
                throw new \LogicException("Result for {$bookmarkClass} must be created");
        }
    }
}
