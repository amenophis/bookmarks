<?php

declare(strict_types=1);

namespace App\Application\API\Action\AddBookmarkKeyword;

use App\Application\API\Result\BookmarkResult;
use App\Application\API\ResultInterface;

class Result implements ResultInterface
{
    private BookmarkResult $bookmark;

    public function __construct(BookmarkResult $bookmark)
    {
        $this->bookmark = $bookmark;
    }

    public function getResponse()
    {
        return $this->bookmark;
    }
}
