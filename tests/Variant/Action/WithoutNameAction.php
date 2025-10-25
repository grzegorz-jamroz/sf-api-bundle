<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Variant\Action;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/without-name', methods: ['POST'])]
class WithoutNameAction
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse();
    }
}
