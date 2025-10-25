<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Controller\ApiController;

use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Ifrost\ApiBundle\Tests\Variant\Controller\ApiControllerVariant;
use Ifrost\ApiBundle\Tests\Variant\Sample;

class GetApiRequestServiceTest extends TestCase
{
    public function testShouldReturnInstanceOfApiRequestInterface()
    {
        // Given
        $controller = new ApiControllerVariant();

        // When & Then
        $this->assertInstanceOf(ApiRequestInterface::class, $controller->getApiRequestService());
    }

    public function testShouldThrowRuntimeExceptionWhenContainerReturnSomethingDifferentThanApiRequestInterface()
    {
        // Expect
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(sprintf('Container identifier "ifrost_api.api_request" is not instance of %s', ApiRequestInterface::class));

        // Given
        $controller = new ApiControllerVariant();
        $controller->getContainer()->set('ifrost_api.api_request', new Sample());

        // When & Then
        $controller->getApiRequestService();
    }
}
