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
        $code = $exception->getCode() ?: 400;
        $message = 'Oops! An Error Occurred';

        if (in_array($_ENV['APP_ENV'], ['dev', 'test'])) {
            $message = $exception->getMessage();
        }

        $response = new JsonResponse(
            ['message' => $message],
            $code,
        );
        $event->setResponse($response);
    }
}
