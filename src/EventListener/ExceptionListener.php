<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\EventListener;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $data = ['message' => 'Oops! An Error Occurred'];

        if (in_array($_ENV['APP_ENV'], ['dev', 'test'])) {
            $data['message'] = $exception->getMessage();
            $data['exceptionClass'] = $exception::class;
        }

        $response = new JsonResponse();
        $response->setJson(json_encode($data, JSON_UNESCAPED_UNICODE));

        try {
            $response->setStatusCode($exception->getCode());
        } catch (InvalidArgumentException) {
            $response->setStatusCode(400);
        }

        $event->setResponse($response);
    }
}
