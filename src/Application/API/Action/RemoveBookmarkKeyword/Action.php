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
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks/{id}/keywords/{keyword}", methods={"DELETE"})
     *
     * @OA\Delete(
     *     tags={"Bookmarks Keywords"},
     *     description="Remove a keyword from bookmark",
     *     responses={
     *         @OA\Response(
     *             response=200,
     *             description="Keyword is removed from bookmark",
     *         ),
     *         @OA\Response(
     *             response=400,
     *             description="The keyword does not exists in the bookmark"
     *         ),
     *         @OA\Response(
     *             response=404,
     *             description="The bookmark does not exists"
     *         )
     *     }
     * )
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
