<?php

declare(strict_types=1);

namespace Unit\App\Application\API\Result;

use App\Application\API\Result\FlickrBookmarkResult;
use App\Application\API\Result\ResultFactory;
use App\Application\API\Result\VimeoBookmarkResult;
use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Model\BookmarkId;
use App\Domain\Data\Model\FlickrBookmark;
use App\Domain\Data\Model\VimeoBookmark;
use App\Domain\URIMetadata\URIMetadata;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ResultFactoryTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @dataProvider provideSupportedBookmarkTypes
     */
    public function testSupportedBookmarkTypes(Bookmark $bookmark, string $bookmarkResultClass): void
    {
        $resultFactory = new ResultFactory();

        $result = $resultFactory->createResultFromBookmark($bookmark);
        $this->assertInstanceOf($bookmarkResultClass, $result);
    }

    public function provideSupportedBookmarkTypes(): \Generator
    {
        yield [
            FlickrBookmark::create(BookmarkId::fromString('c7e0cf14-0712-41cd-aed6-8af870e0cbf1'), 'http://fake.com', new \DateTimeImmutable(), new URIMetadata([])),
            FlickrBookmarkResult::class,
        ];

        yield [
            VimeoBookmark::create(BookmarkId::fromString('c7e0cf14-0712-41cd-aed6-8af870e0cbf1'), 'http://fake.com', new \DateTimeImmutable(), new URIMetadata([])),
            VimeoBookmarkResult::class,
        ];
    }

    public function testUnsupportedBookmarkType(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Result for Unit\App\Application\API\Result\FakeBookmark must be created');

        $resultFactory = new ResultFactory();
        $resultFactory->createResultFromBookmark(new FakeBookmark());
    }
}

class FakeBookmark extends Bookmark
{
    public function __construct()
    {
        parent::__construct(BookmarkId::fromString('c7e0cf14-0712-41cd-aed6-8af870e0cbf1'), 'https://fake.com/', new \DateTimeImmutable(), new URIMetadata([]));
    }
}
