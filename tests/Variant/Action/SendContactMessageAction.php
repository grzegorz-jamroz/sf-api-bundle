<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Variant\Action;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/contact/send-message', name: 'contact_send_message', methods: ['POST'])]
class SendContactMessageAction
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['message' => 'Message has been sent successfully.']);
    }
}
