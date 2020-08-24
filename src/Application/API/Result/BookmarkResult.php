<?php

declare(strict_types=1);

namespace App\Application\API\Result;

use App\Domain\Data\Model\Bookmark;

abstract class BookmarkResult
{
    public string $id;
    public string $url;
    public ?string $title;
    public ?string $author;
    public \DateTimeInterface $addedAt;
    /**
     * @var string[]
     */
    public array $keywords;

    public function __construct(Bookmark $bookmark)
    {
        $this->id       = (string) $bookmark->getId();
        $this->url      = $bookmark->getUrl();
        $this->title    = $bookmark->getTitle();
        $this->author   = $bookmark->getAuthor();
        $this->addedAt  = $bookmark->getAddedAt();
        $this->keywords = $bookmark->getKeywords();
    }
}
