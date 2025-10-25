<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Variant\Action;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/invalid-abstract-action', name: 'invalid_abstract_action', methods: ['POST'])]
abstract class AbstractSampleAction
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse();
    }
}
