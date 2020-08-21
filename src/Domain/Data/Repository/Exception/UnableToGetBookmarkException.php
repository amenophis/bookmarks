<?php

declare(strict_types=1);

namespace App\Domain\Data\Repository\Exception;

use Throwable;

class UnableToGetBookmarkException extends \Exception
{
    public function __construct(int $bookmarkId, Throwable $previous = null)
    {
        parent::__construct("Unable to get Bookmark with id {$bookmarkId}", 0, $previous);
    }
}
