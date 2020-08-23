<?php

declare(strict_types=1);

namespace App\Domain\UseCase\RemoveAKeywordFromBookmark;

use App\Domain\Data\Model\Bookmark;

class Output
{
    private Bookmark $bookmark;

    public function __construct(Bookmark $bookmark)
    {
        $this->bookmark = $bookmark;
    }

    public function getBookmark(): Bookmark
    {
        return $this->bookmark;
    }
}
