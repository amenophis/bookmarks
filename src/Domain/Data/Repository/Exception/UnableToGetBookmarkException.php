<?php

declare(strict_types=1);

namespace App\Domain\Data\Repository\Exception;

use App\Domain\Data\Model\BookmarkId;
use Throwable;

class UnableToGetBookmarkException extends \Exception
{
    public function __construct(BookmarkId $bookmarkId, Throwable $previous = null)
    {
        parent::__construct("Unable to get Bookmark with id {$bookmarkId}", 0, $previous);
    }
}
