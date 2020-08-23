<?php

declare(strict_types=1);

namespace App\Application\API\Action\ListBookmarks;

use App\Application\API\Result\ResultFactory;
use App\Domain\UseCase\ListBookmarks;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks", methods={"GET"})
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
