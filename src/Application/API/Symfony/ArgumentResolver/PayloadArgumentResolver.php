<?php

declare(strict_types=1);

namespace App\Application\API\Symfony\ArgumentResolver;

use App\Application\API\Exception\InvalidPayloadException;
use App\Application\API\PayloadInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PayloadArgumentResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator  = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return
            'json' === $request->getContentType()
            && is_subclass_of($argument->getType(), PayloadInterface::class)
        ;
    }

    /**
     * @throws InvalidPayloadException
     *
     * @return iterable<PayloadInterface>
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $content    = $request->getContent() ?: '{}';
        $payload    = $this->serializer->deserialize($content, $argument->getType(), 'json');
        $violations = $this->validator->validate($payload);
        if ($violations->count() > 0) {
            throw new InvalidPayloadException($violations);
        }

        yield $payload;
    }
}
