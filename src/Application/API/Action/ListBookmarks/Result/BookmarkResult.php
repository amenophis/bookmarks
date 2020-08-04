<?php

declare(strict_types=1);

namespace App\Application\API\Action\ListBookmarks\Result;

class BookmarkResult implements \JsonSerializable
{
    private int $id;
    private string $url;
    private ?string $title;
    private ?string $author;
    private \DateTimeInterface $addedAt;

    public function __construct(int $id, string $url, ?string $title, ?string $author, \DateTimeInterface $addedAt)
    {
        $this->id      = $id;
        $this->url     = $url;
        $this->title   = $title;
        $this->author  = $author;
        $this->addedAt = $addedAt;
    }

    public function jsonSerialize()
    {
        return [
            'id'      => $this->id,
            'url'     => $this->url,
            'title'   => $this->title,
            'author'  => $this->author,
            'addedAt' => $this->addedAt,
        ];
    }
}
