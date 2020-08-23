<?php

declare(strict_types=1);

namespace Func\App\Application\API;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Func\App\FunctionalTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class AddBookmarkKeywordTest extends FunctionalTestCase
{
    use PHPMatcherAssertions;
    use RefreshDatabaseTrait;

    public function testAddingKeywordOnNotExistingBookmark(): void
    {
        $this->postJson('/bookmarks/af1231ab-a1ab-418a-9349-f06534bbf78a/keywords/Voiture');

        $this->assertNotFoundResponse();
    }

    public function testAddExistingKeywordThrows400Response(): void
    {
        $this->postJson('/bookmarks/c47f0bae-49a6-4b66-8504-e55d03dc3f09/keywords/Voiture');

        $this->assertBadRequestResponse('Keyword "Voiture" already exists');
    }

    public function testAddKeywordSuccess(): void
    {
        $this->postJson('/bookmarks/b841b091-8377-4dcd-a3f2-37a642920d84/keywords/Collection');

        $this->assertCreatedResponse();

        $this->assertMatchesPattern([
            'id'       => 'b841b091-8377-4dcd-a3f2-37a642920d84',
            'url'      => 'https://vimeo.com/437769507',
            'title'    => 'La Voiture',
            'author'   => 'Gary Bird',
            'addedAt'  => '@string@.isDateTime()',
            'width'    => 426,
            'height'   => 240,
            'duration' => 22,
            'keywords' => ['Voiture', 'Collection'],
        ], $this->getResponseAsJsonDecode());
    }
}
