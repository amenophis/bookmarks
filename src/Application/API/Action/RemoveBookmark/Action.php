<?php

declare(strict_types=1);

namespace App\Application\API\Action\RemoveBookmark;

use App\Application\API\Exception\NotFoundException;
use App\Domain\Data\Model\BookmarkId;
use App\Domain\Data\Repository\Exception\UnableToGetBookmarkException;
use App\Domain\UseCase\RemoveABookmark;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks/{id}", methods={"DELETE"})
     *
     * @throws NotFoundException
     */
    public function __invoke(BookmarkId $id, RemoveABookmark\Handler $handler): Result
    {
        try {
            $handler->__invoke(new RemoveABookmark\Input($id));

            return new Result();
        } catch (UnableToGetBookmarkException $e) {
            throw new NotFoundException();
        }
    }
}
