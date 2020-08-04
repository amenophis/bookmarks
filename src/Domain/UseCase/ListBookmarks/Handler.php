<?php

declare(strict_types=1);

namespace App\Domain\UseCase\ListBookmarks;

use App\Domain\Data\Repository\Bookmarks;

class Handler
{
    private Bookmarks $bookmarks;

    public function __construct(Bookmarks $bookmarks)
    {
        $this->bookmarks = $bookmarks;
    }

    public function __invoke(Input $input): Output
    {
        return new Output($this->bookmarks->all());
    }
}
