<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Controller\ApiController;

use Ifrost\ApiBundle\Controller\ApiController as Controller;
use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use PHPUnit\Framework\TestCase;

class GetSubscribedServicesTest extends TestCase
{
    public function testShouldReturnArrayWithDesiredSubscribedServices(): void
    {
        // Given
        $services = Controller::getSubscribedServices();

        // When & Then
        $this->assertEquals($services['ifrost_api.api_request'], sprintf('?%s', ApiRequestInterface::class));
    }
}
