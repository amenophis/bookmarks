<?php

declare(strict_types=1);

namespace App\Application\API\Action\CreateBookmark;

use App\Application\API\Result\ResultFactory;
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

        return new Result($resultFactory->createResultFromBookmark($output->getBookmark()));
    }
}
