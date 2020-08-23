<?php

declare(strict_types=1);

namespace App\Application\API\Action\RemoveBookmarkKeyword;

use App\Application\API\Exception\DomainException;
use App\Application\API\Exception\NotFoundException;
use App\Application\API\Result\ResultFactory;
use App\Domain\Data\Model\BookmarkId;
use App\Domain\Data\Model\Exception\KeywordDoesntExistsException;
use App\Domain\Data\Repository\Exception\UnableToGetBookmarkException;
use App\Domain\UseCase\RemoveAKeywordFromBookmark;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks/{id}/keywords/{keyword}", methods={"DELETE"})
     */
    public function __invoke(BookmarkId $id, string $keyword, RemoveAKeywordFromBookmark\Handler $handler, ResultFactory $resultFactory): Result
    {
        try {
            $output = $handler->__invoke(
                new RemoveAKeywordFromBookmark\Input($id, $keyword)
            );

            return new Result($resultFactory->createResultFromBookmark($output->getBookmark()));
        } catch (UnableToGetBookmarkException $e) {
            throw new NotFoundException();
        } catch (KeywordDoesntExistsException $e) {
            throw new DomainException($e);
        }
    }
}
