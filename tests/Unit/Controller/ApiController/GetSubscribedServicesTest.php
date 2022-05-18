<?php
declare(strict_types=1);

namespace Tests\Unit\Controller\ApiController;

use Ifrost\ApiBundle\Controller\ApiController as Controller;
use Ifrost\ApiBundle\Utility\ApiRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class GetSubscribedServicesTest extends TestCase
{
    public function testShouldReturnArrayWithDesiredSubscribedServices(): void
    {
        // Given
        $services = Controller::getSubscribedServices();

        // When & Then
        $this->assertEquals($services['app.api_request'], sprintf('?%s', ApiRequest::class));
        $this->assertEquals($services['messenger.default_bus'], sprintf('?%s', MessageBusInterface::class));
    }
}
