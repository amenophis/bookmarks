<?php

declare(strict_types=1);

namespace Unit\App\Domain\UseCase\AddABookmark;

use App\Domain\Data\Factory\BookmarkFactory;
use App\Domain\Data\Factory\Exception\UnsupportedBookmarkTypeException;
use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Repository\Bookmarks;
use App\Domain\UseCase\AddABookmark;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class HandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testSupportedBookmarkURL(): void
    {
        $url = 'http://supported.com/picture/123';

        $bookmarksProphecy = $this->prophesize(Bookmarks::class);
        $factoryProphecy   = $this->prophesize(BookmarkFactory::class);
        $bookmarkProphecy  = $this->prophesize(Bookmark::class);

        $bookmark = $bookmarkProphecy->reveal();

        $factoryProphecy->createBookmarkFromUrl($url)->shouldBeCalled()->willReturn(
            $bookmark
        );

        $handler = new AddABookmark\Handler(
            $bookmarksProphecy->reveal(),
            $factoryProphecy->reveal(),
        );

        $output = $handler->__invoke(new AddABookmark\Input($url));

        $this->assertEquals($bookmark, $output->getBookmark());
    }

    public function testUnsupportedBookmarkURL(): void
    {
        $url = 'http://unsupported.com/video/456';

        $bookmarksProphecy = $this->prophesize(Bookmarks::class);
        $factoryProphecy   = $this->prophesize(BookmarkFactory::class);

        $factoryProphecy->createBookmarkFromUrl($url)->shouldBeCalled()->willThrow(
            $e = new UnsupportedBookmarkTypeException('Unsupported bookmark type: "unsupported".')
        );

        $handler = new AddABookmark\Handler(
            $bookmarksProphecy->reveal(),
            $factoryProphecy->reveal(),
        );

        $this->expectExceptionObject($e);

        $handler(new AddABookmark\Input($url));
    }
}
