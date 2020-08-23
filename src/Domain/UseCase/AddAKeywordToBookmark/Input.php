<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AddAKeywordToBookmark;

use App\Domain\Data\Model\BookmarkId;

class Input
{
    private BookmarkId $bookmarkId;
    private string $keyword;

    public function __construct(BookmarkId $bookmarkId, string $keyword)
    {
        $this->bookmarkId = $bookmarkId;
        $this->keyword    = $keyword;
    }

    public function getBookmarkId(): BookmarkId
    {
        return $this->bookmarkId;
    }

    public function getKeyword(): string
    {
        return $this->keyword;
    }
}
