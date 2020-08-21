<?php

declare(strict_types=1);

namespace App\Domain\UseCase\RemoveABookmark;

class Input
{
    private int $bookmarkId;

    public function __construct(int $bookmarkId)
    {
        $this->bookmarkId = $bookmarkId;
    }

    public function getBookmarkId(): int
    {
        return $this->bookmarkId;
    }
}
