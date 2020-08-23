<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AddAKeywordToBookmark;

use App\Domain\Data\Model\Exception\KeywordAlreadyExistsException;
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
     * @throws KeywordAlreadyExistsException
     */
    public function __invoke(Input $input): Output
    {
        $bookmark = $this->bookmarks->get($input->getBookmarkId());
        $bookmark->addKeyword($input->getKeyword());
        $this->bookmarks->save($bookmark);

        return new Output($bookmark);
    }
}
