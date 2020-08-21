<?php

declare(strict_types=1);

namespace App\Domain\Data\Factory;

use App\Domain\Clock;
use App\Domain\Data\Factory\Exception\UnsupportedBookmarkTypeException;
use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Model\FlickrBookmark;
use App\Domain\Data\Model\VimeoBookmark;
use App\Domain\URIMetadata\URIMetadataReader;

class BookmarkFactory
{
    private URIMetadataReader $embedReader;
    private Clock $clock;

    public function __construct(URIMetadataReader $embedReader, Clock $clock)
    {
        $this->embedReader = $embedReader;
        $this->clock       = $clock;
    }

    /**
     * @throws UnsupportedBookmarkTypeException
     */
    public function createBookmarkFromUrl(string $url): Bookmark
    {
        $metadata = $this->embedReader->read($url);

        switch ($providerName = $metadata->get('provider_name')) {
            case 'Flickr':
                return FlickrBookmark::create($url, $this->clock->now(), $metadata);
            case 'Vimeo':
                return VimeoBookmark::create($url, $this->clock->now(), $metadata);
            default:
                throw new UnsupportedBookmarkTypeException((string) $providerName);
        }
    }
}
