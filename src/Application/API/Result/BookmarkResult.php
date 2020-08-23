<?php

declare(strict_types=1);

namespace App\Application\API\Result;

use App\Domain\Data\Model\Bookmark;

class BookmarkResult implements \JsonSerializable
{
    private string $id;
    private string $url;
    private ?string $title;
    private ?string $author;
    private \DateTimeInterface $addedAt;
    /**
     * @var string[]
     */
    private array $keywords;

    public function __construct(Bookmark $bookmark)
    {
        $this->id       = (string) $bookmark->getId();
        $this->url      = $bookmark->getUrl();
        $this->title    = $bookmark->getTitle();
        $this->author   = $bookmark->getAuthor();
        $this->addedAt  = $bookmark->getAddedAt();
        $this->keywords = $bookmark->getKeywords();
    }

    public function jsonSerialize()
    {
        return [
            'id'       => $this->id,
            'url'      => $this->url,
            'title'    => $this->title,
            'author'   => $this->author,
            'addedAt'  => $this->addedAt,
            'keywords' => $this->keywords,
        ];
    }
}
