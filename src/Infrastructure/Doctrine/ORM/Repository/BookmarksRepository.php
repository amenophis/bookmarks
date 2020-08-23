<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\ORM\Repository;

use App\Domain\Data\Model\Bookmark;
use App\Domain\Data\Model\BookmarkId;
use App\Domain\Data\Repository\Bookmarks;
use App\Domain\Data\Repository\Exception\UnableToGetBookmarkException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bookmark>
 */
class BookmarksRepository extends ServiceEntityRepository implements Bookmarks
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookmark::class);
    }

    public function save(Bookmark $bookmark): void
    {
        $this->_em->persist($bookmark);
        $this->_em->flush();
    }

    public function all(): array
    {
        return $this->findAll();
    }

    public function get(BookmarkId $bookmarkId): Bookmark
    {
        /** @var Bookmark|null $bookmark */
        $bookmark = $this->find($bookmarkId);
        if (null === $bookmark) {
            throw new UnableToGetBookmarkException($bookmarkId);
        }

        return $bookmark;
    }

    public function remove(Bookmark $bookmark): void
    {
        $this->_em->remove($bookmark);
        $this->_em->flush();
    }
}
