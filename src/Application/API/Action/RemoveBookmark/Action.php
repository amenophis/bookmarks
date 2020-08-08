<?php

declare(strict_types=1);

namespace App\Application\API\Action\RemoveBookmark;

use App\Application\API\Exception\NotFoundException;
use App\Domain\Data\Repository\Exception\UnableToGetBookmarkException;
use App\Domain\UseCase\RemoveABookmark;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
     *
     * @throws NotFoundException
     */
    public function __invoke(RemoveABookmark\Handler $handler, int $id): Result
    {
        try {
            $handler->__invoke(new RemoveABookmark\Input($id));

            return new Result();
        } catch (UnableToGetBookmarkException $e) {
            throw new NotFoundException();
        }
    }
}
