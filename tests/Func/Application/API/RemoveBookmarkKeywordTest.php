<?php

declare(strict_types=1);

namespace Func\App\Application\API;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Func\App\FunctionalTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class RemoveBookmarkKeywordTest extends FunctionalTestCase
{
    use PHPMatcherAssertions;
    use RefreshDatabaseTrait;

    public function testAddingKeywordOnNotExistingBookmark(): void
    {
        $this->delete('/bookmarks/1a0d6042-892e-43fc-9e83-018e8711594d/keywords/Voiture');

        $this->assertNotFoundResponse();
    }

    public function testRemoveNotExistingKeywordThrows400Response(): void
    {
        $this->delete('/bookmarks/b841b091-8377-4dcd-a3f2-37a642920d84/keywords/NotExisting');

        $this->assertBadRequestResponse('Keyword "NotExisting" does not exists');
    }

    public function testRemoveKeywordSuccess(): void
    {
        $this->delete('/bookmarks/b841b091-8377-4dcd-a3f2-37a642920d84/keywords/Voiture');

        $this->assertOKResponse();

        $this->assertMatchesPattern([
            'id'       => 'b841b091-8377-4dcd-a3f2-37a642920d84',
            'url'      => 'https://vimeo.com/437769507',
            'title'    => 'La Voiture',
            'author'   => 'Gary Bird',
            'addedAt'  => '@string@.isDateTime()',
            'width'    => 426,
            'height'   => 240,
            'duration' => 22,
            'keywords' => [],
        ], $this->getResponseAsJsonDecode());
    }
}
