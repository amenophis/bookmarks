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
        $this->delete('/bookmarks/f776b852-c068-4a7b-a0e8-335c20b1b5c3');

        $this->assertNotFoundResponse();
    }

    public function testDeleteSuccess(): void
    {
        $this->delete('/bookmarks/b841b091-8377-4dcd-a3f2-37a642920d84');

        $this->assertEmptyResponse();
    }
}
