<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $message = 'Oops! An Error Occurred';

        if (in_array($_ENV['APP_ENV'], ['dev', 'test'])) {
            $message = $exception->getMessage();
        }

        $response = new JsonResponse();
        $response->setJson(json_encode(['message' => $message], JSON_UNESCAPED_UNICODE));

        try {
            $response->setStatusCode($exception->getCode());
        } catch (\InvalidArgumentException) {
            $response->setStatusCode(400);
        }

        $event->setResponse($response);
    }
}
