<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Variant\Action;

use Symfony\Component\HttpFoundation\JsonResponse;

class InvalidActionWithoutAttribute
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse();
    }
}
