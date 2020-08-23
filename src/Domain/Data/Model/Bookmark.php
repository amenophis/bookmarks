<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\Data\Model\Exception\KeywordAlreadyExistsException;
use App\Domain\Data\Model\Exception\KeywordDoesntExistsException;
use App\Domain\URIMetadata\URIMetadata;

abstract class Bookmark
{
    private BookmarkId $id;
    private string $url;
    private ?string $title;
    private ?string $author;
    private \DateTimeInterface $addedAt;
    /**
     * @var string[]
     */
    private array $keywords = [];

    protected function __construct(BookmarkId $id, string $url, \DateTimeInterface $addedAt, URIMetadata $metadata)
    {
        $this->id      = $id;
        $this->url     = $url;
        $this->title   = (string) $metadata->get('title');
        $this->author  = (string) $metadata->get('author');
        $this->addedAt = $addedAt;
    }

    /**
     * @throws KeywordAlreadyExistsException
     */
    public function addKeyword(string $keyword): void
    {
        if (\in_array($keyword, $this->keywords, true)) {
            throw new KeywordAlreadyExistsException($keyword);
        }

        $this->keywords[] = $keyword;
    }

    /**
     * @throws KeywordDoesntExistsException
     */
    public function removeKeyword(string $keyword): void
    {
        if (!\in_array($keyword, $this->keywords, true)) {
            throw new KeywordDoesntExistsException($keyword);
        }

        $this->keywords = array_diff($this->keywords, [$keyword]);
    }

    public function getId(): BookmarkId
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getAddedAt(): \DateTimeInterface
    {
        return $this->addedAt;
    }

    /**
     * @return string[]
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }
}
