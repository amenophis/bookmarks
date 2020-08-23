<?php

declare(strict_types=1);

namespace App\Application\API\Action\RemoveBookmarkKeyword;

use App\Application\API\Result\BookmarkResult;
use App\Application\API\ResultInterface;

class Result implements ResultInterface
{
    public function getStatusCode(): int
    {
        return 200;
    }

    private BookmarkResult $bookmark;

    public function __construct(BookmarkResult $bookmark)
    {
        $this->bookmark = $bookmark;
    }

    public function jsonSerialize()
    {
        return $this->bookmark;
    }
}
