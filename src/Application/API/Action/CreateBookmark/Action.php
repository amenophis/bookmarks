<?php

declare(strict_types=1);

namespace App\Application\API\Action\CreateBookmark;

use App\Application\API\Result\ResultFactory;
use App\Domain\UseCase\AddABookmark;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    /**
     * @Route("/bookmarks", methods={"POST"})
     *
     * @OA\Post(
     *     tags={"Bookmarks"},
     *     description="Create a bookmark",
     *     requestBody=@OA\RequestBody(
     *         content={
     *             @OA\MediaType(mediaType="application/json", schema=@OA\Schema(ref=@Model(type=Payload::class)))
     *         }
     *     ),
     *     responses={
     *         @OA\Response(
     *             response=201,
     *             description="Bookmark sucessfully added"
     *         ),
     *         @OA\Response(
     *             response=400,
     *             description="The payload is invalid"
     *         )
     *     }
     * )
     */
    public function __invoke(Payload $payload, AddABookmark\Handler $handler, ResultFactory $resultFactory): Result
    {
        $output = $handler->__invoke(
            new AddABookmark\Input($payload->url)
        );

        return new Result($resultFactory->createResultFromBookmark($output->getBookmark()));
    }
}
