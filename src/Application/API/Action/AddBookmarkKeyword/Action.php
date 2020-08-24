<?php

declare(strict_types=1);

namespace App\Application\API\Action\AddBookmarkKeyword;

use App\Application\API\Exception\DomainException;
use App\Application\API\Exception\NotFoundException;
use App\Application\API\Result\ResultFactory;
use App\Domain\Data\Model\BookmarkId;
use App\Domain\Data\Model\Exception\KeywordAlreadyExistsException;
use App\Domain\Data\Repository\Exception\UnableToGetBookmarkException;
use App\Domain\UseCase\AddAKeywordToBookmark;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks/{id}/keywords/{keyword}", methods={"POST"})
     *
     * @OA\Post(
     *     tags={"Bookmarks Keywords"},
     *     description="Add a keyword to bookmark",
     *     responses={
     *         @OA\Response(
     *             response=200,
     *             description="The keyword has been added to the bookmark"
     *         ),
     *         @OA\Response(
     *             response=400,
     *             description="The keyword already exists in the bookmark"
     *         ),
     *         @OA\Response(
     *             response=404,
     *             description="The bookmark does not exists"
     *         )
     *     }
     * )
     */
    public function __invoke(BookmarkId $id, string $keyword, AddAKeywordToBookmark\Handler $handler, ResultFactory $resultFactory): Result
    {
        try {
            $output = $handler->__invoke(
                new AddAKeywordToBookmark\Input($id, $keyword)
            );

            return new Result($resultFactory->createResultFromBookmark($output->getBookmark()));
        } catch (UnableToGetBookmarkException $e) {
            throw new NotFoundException();
        } catch (KeywordAlreadyExistsException $e) {
            throw new DomainException($e);
        }
    }
}
