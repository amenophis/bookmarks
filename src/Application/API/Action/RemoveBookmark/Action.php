<?php

declare(strict_types=1);

namespace App\Application\API\Action\RemoveBookmark;

use App\Application\API\Exception\NotFoundException;
use App\Domain\Data\Model\BookmarkId;
use App\Domain\Data\Repository\Exception\UnableToGetBookmarkException;
use App\Domain\UseCase\RemoveABookmark;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks/{id}", methods={"DELETE"})
     *
     * @OA\Delete(
     *     tags={"Bookmarks"},
     *     description="Delete a bookmark",
     *     responses={
     *         @OA\Response(
     *             response=204,
     *             description="Bookmark is deleted"
     *         ),
     *         @OA\Response(
     *             response=404,
     *             description="The bookmark does not exists"
     *         )
     *     }
     * )
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
