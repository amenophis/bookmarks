<?php

declare(strict_types=1);

namespace App\Application\API\Action\ListBookmarks;

use App\Application\API\Action\ListBookmarks\Result\BookmarkResult;
use App\Application\API\ResultInterface;

class Result implements ResultInterface
{
    /**
     * @var BookmarkResult[]
     */
    private array $bookmarks;

    /**
     * @param BookmarkResult[] $bookmarks
     */
    public function __construct(array $bookmarks)
    {
        $this->bookmarks = $bookmarks;
    }

    public function jsonSerialize()
    {
        return $this->bookmarks;
    }
}
