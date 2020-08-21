<?php

declare(strict_types=1);

namespace Func\App\Application\API;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Func\App\FunctionalTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class DeleteBookmarkTest extends FunctionalTestCase
{
    use PHPMatcherAssertions;
    use RefreshDatabaseTrait;

    public function testDeleteNotExistingBookmark(): void
    {
        $this->delete('/bookmarks/100000');

        $this->assertNotFoundResponse();
    }

    public function testDeleteSuccess(): void
    {
        $this->delete('/bookmarks/1');

        $this->assertEmptyResponse();
    }
}
