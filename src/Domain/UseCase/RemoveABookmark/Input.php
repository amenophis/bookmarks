<?php

declare(strict_types=1);

namespace App\Domain\UseCase\RemoveABookmark;

use App\Domain\Data\Model\BookmarkId;

class Input
{
    private BookmarkId $bookmarkId;

    public function __construct(BookmarkId $bookmarkId)
    {
        $this->bookmarkId = $bookmarkId;
    }

    public function getBookmarkId(): BookmarkId
    {
        return $this->bookmarkId;
    }
}
