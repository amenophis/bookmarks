<?php

declare(strict_types=1);

namespace App\Domain\Data\Repository;

use App\Domain\Data\Model\Bookmark;

interface Bookmarks
{
    public function save(Bookmark $bookmark): void;
}
