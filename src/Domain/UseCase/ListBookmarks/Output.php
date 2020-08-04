<?php

declare(strict_types=1);

namespace App\Domain\UseCase\ListBookmarks;

use App\Domain\Data\Model\Bookmark;

class Output
{
    /**
     * @var Bookmark[]
     */
    private array $bookmarks;

    /**
     * @param Bookmark[] $bookmarks
     */
    public function __construct(array $bookmarks)
    {
        $this->bookmarks = $bookmarks;
    }

    /**
     * @return Bookmark[]
     */
    public function getBookmarks(): array
    {
        return $this->bookmarks;
    }
}
