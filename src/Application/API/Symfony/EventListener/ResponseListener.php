<?php

declare(strict_types=1);

namespace App\Application\API\Symfony\EventListener;

use App\Application\API\Exception\InvalidPayloadException;
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

        switch ($event->getRequest()->getMethod()) {
            case 'POST':
                $statusCode = 201;
                break;
            case 'DELETE':
                $statusCode = 204;
                break;
            default:
                $statusCode = 200;
                break;
        }

        $json     = $this->serializer->serialize($result, 'json');
        $response = new JsonResponse($json, $statusCode, [], true);

        $event->setResponse($response);
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        if (!$throwable instanceof InvalidPayloadException) {
            return;
        }

        $result = $this->serializer->serialize(
            new ViolationListResult($throwable->getViolations()),
            'json'
        );
        $response = new JsonResponse($result, 400, [], true);

        $event->setResponse($response);
    }
}
