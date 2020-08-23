<?php

declare(strict_types=1);

namespace App\Domain\Data\Factory;

use App\Domain\Clock;
use App\Domain\Data\Factory\Exception\UnsupportedBookmarkTypeException;
use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Model\BookmarkId;
use App\Domain\Data\Model\FlickrBookmark;
use App\Domain\Data\Model\VimeoBookmark;
use App\Domain\IdGenerator;
use App\Domain\URIMetadata\URIMetadataReader;

class BookmarkFactory
{
    private URIMetadataReader $embedReader;
    private Clock $clock;
    private IdGenerator $idGenerator;

    public function __construct(URIMetadataReader $embedReader, Clock $clock, IdGenerator $idGenerator)
    {
        $this->embedReader = $embedReader;
        $this->clock       = $clock;
        $this->idGenerator = $idGenerator;
    }

    /**
     * @throws UnsupportedBookmarkTypeException
     */
    public function createBookmarkFromUrl(string $url): Bookmark
    {
        $metadata = $this->embedReader->read($url);

        switch ($providerName = $metadata->get('provider_name')) {
            case 'Flickr':
                return FlickrBookmark::create(
                    BookmarkId::fromString($this->idGenerator->generate()),
                    $url,
                    $this->clock->now(),
                    $metadata
                );
            case 'Vimeo':
                return VimeoBookmark::create(
                    BookmarkId::fromString($this->idGenerator->generate()),
                    $url,
                    $this->clock->now(),
                    $metadata
                );
            default:
                throw new UnsupportedBookmarkTypeException((string) $providerName);
        }
    }
}
