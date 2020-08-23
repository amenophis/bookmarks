<?php

declare(strict_types=1);

namespace App\Application\API\Symfony\ArgumentResolver;

use App\Domain\Data\Model\BookmarkId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class BookmarkIdArgumentResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return BookmarkId::class === $argument->getType();
    }

    /**
     * @return iterable<BookmarkId>
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield BookmarkId::fromString($request->attributes->get($argument->getName()));
    }
}
