<?php

declare(strict_types=1);

namespace App\Application\API\Symfony\EventListener;

use App\Application\API\Exception\DomainException;
use App\Application\API\Exception\InvalidPayloadException;
use App\Application\API\Exception\NotFoundException;
use App\Application\API\ResultInterface;
use App\Application\API\Violations\ViolationListResult;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseListener
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelView(ViewEvent $event): void
    {
        $result = $event->getControllerResult();

        if (!$result instanceof ResultInterface) {
            return;
        }

        if (null === $result->getResponse()) {
            $response = new JsonResponse(null, 204);
            $event->setResponse($response);

            return;
        }

        $statusCode = 200;
        if ('POST' === $event->getRequest()->getMethod()) {
            $statusCode = 201;
        }
        $json = $this->serializer->serialize($result->getResponse(), 'json');

        $response = new JsonResponse($json, $statusCode, [], true);
        $event->setResponse($response);
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        switch (true) {
            case $throwable instanceof InvalidPayloadException:
                $response = $this->handleInvalidPayloadException($throwable);
            break;
            case $throwable instanceof NotFoundException:
                $response = $this->handleNotFoundException($throwable);
            break;
            case $throwable instanceof DomainException:
                $response = $this->handleDomainException($throwable);
                break;
            default:
                return;
        }

        $event->setResponse($response);
    }

    private function handleInvalidPayloadException(InvalidPayloadException $e): JsonResponse
    {
        $result = $this->serializer->serialize(
            new ViolationListResult($e->getViolations()),
            'json'
        );

        return new JsonResponse($result, 400, [], true);
    }

    private function handleNotFoundException(NotFoundException $e): JsonResponse
    {
        return new JsonResponse($e->getMessage(), 404);
    }

    private function handleDomainException(DomainException $e): JsonResponse
    {
        return new JsonResponse($e->getMessage(), 400);
    }
}
