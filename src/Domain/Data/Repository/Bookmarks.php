<?php

declare(strict_types=1);

namespace App\Domain\Data\Repository;

use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Model\BookmarkId;
use App\Domain\Data\Repository\Exception\UnableToGetBookmarkException;

interface Bookmarks
{
    public function save(Bookmark $bookmark): void;

    /**
     * @return Bookmark[]
     */
    public function all(): array;

    /**
     * @throws UnableToGetBookmarkException
     */
    public function get(BookmarkId $bookmarkId): Bookmark;

    public function remove(Bookmark $bookmark): void;
}
