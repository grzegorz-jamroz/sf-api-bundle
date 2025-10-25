<?php
declare(strict_types=1);

namespace Ifrost\ApiBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonExceptionResponse extends JsonResponse
{
    public function __construct(
        mixed $data = null,
        \Throwable $e,
        int $status = 400,
        array $headers = [],
        bool $json = false
    )
    {
        if ($_ENV['APP_ENV'] === 'dev') {
            $data = [
                ...$data,
                'debug' => [
                    'message' => $e->getMessage(),
                    'exceptionClass' => $e::class,
                ],
            ];
        }

        parent::__construct($data, $status, $headers, $json);
    }
}
