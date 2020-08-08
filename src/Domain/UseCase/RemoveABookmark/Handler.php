<?php

declare(strict_types=1);

namespace App\Domain\UseCase\RemoveABookmark;

use App\Domain\Data\Repository\Bookmarks;
use App\Domain\Data\Repository\Exception\UnableToGetBookmarkException;

class Handler
{
    private Bookmarks $bookmarks;

    public function __construct(Bookmarks $bookmarks)
    {
        $this->bookmarks = $bookmarks;
    }

    /**
     * @throws UnableToGetBookmarkException
     */
    public function __invoke(Input $input): Output
    {
        $bookmark = $this->bookmarks->get($input->getBookmarkId());

        $this->bookmarks->remove($bookmark);

        return new Output();
    }
}
