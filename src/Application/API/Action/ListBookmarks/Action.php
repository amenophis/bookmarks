<?php

declare(strict_types=1);

namespace App\Application\API\Action\ListBookmarks;

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

        return $resultFactory->createResultFromBookmark($output->getBookmarks());
    }
}
