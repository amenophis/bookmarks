<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AddABookmark;

use App\Domain\Data\Factory\BookmarkFactory;
use App\Domain\Data\Factory\Exception\UnsupportedBookmarkTypeException;
use App\Domain\Data\Repository\Bookmarks;

class Handler
{
    private Bookmarks $bookmarks;
    private BookmarkFactory $factory;

    public function __construct(Bookmarks $bookmarks, BookmarkFactory $factory)
    {
        $this->bookmarks = $bookmarks;
        $this->factory   = $factory;
    }

    /**
     * @throws UnsupportedBookmarkTypeException
     */
    public function __invoke(Input $input): Output
    {
        $bookmark = $this->factory->createBookmarkFromUrl($input->getUrl());

        $this->bookmarks->save($bookmark);

        return new Output($bookmark);
    }
}
