<?php

declare(strict_types=1);

namespace App\Application\API\Action\CreateBookmark;

use App\Application\API\Action\CreateBookmark\Result\Result;
use App\Domain\UseCase\AddABookmark;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks", methods={"POST"})
     */
    public function __invoke(Payload $payload, AddABookmark\Handler $handler, ResultFactory $resultFactory): Result
    {
        $output = $handler->__invoke(
            new AddABookmark\Input($payload->url)
        );

        return $resultFactory->createResultFromBookmark($output->getBookmark());
    }
}
