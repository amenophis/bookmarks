<?php

declare(strict_types=1);

namespace App\Application\API\Action\ListBookmarks;

use App\Application\API\Result\ResultFactory;
use App\Domain\UseCase\ListBookmarks;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks", methods={"GET"})
     *
     * @OA\Get(
     *     tags={"Bookmarks"},
     *     description="List existing bookmarks",
     *     responses={
     *         @OA\Response(
     *             response=200,
     *             description="Get a list of all bookmarks"
     *         )
     *     }
     * )
     */
    public function __invoke(ListBookmarks\Handler $handler, ResultFactory $resultFactory): Result
    {
        $output = $handler->__invoke(new ListBookmarks\Input());

        $bookmarkResults = [];
        foreach ($output->getBookmarks() as $bookmark) {
            $bookmarkResults[] = $resultFactory->createResultFromBookmark($bookmark);
        }

        return new Result($bookmarkResults);
    }
}
