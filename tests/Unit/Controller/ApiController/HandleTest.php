<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Controller\ApiController;

use Ifrost\ApiBundle\Messenger\MessageHandlerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Ifrost\ApiBundle\Tests\Variant\Controller\ApiControllerVariant;
use Ifrost\ApiBundle\Tests\Variant\Messenger\Command\SampleCommand;

class HandleTest extends TestCase
{
    public function testShouldExecuteGivenHandler()
    {
        // Expect & Given
        $name = 'spring';
        $this->expectExceptionMessage(sprintf('This is test error. Given name - %s.', $name));
        $controller = new ApiControllerVariant();
        $controller->addMessageBusToContainer();

        // When & Then
        $controller->handle(new SampleCommand($name));
    }

    public function testShouldThrowRuntimeExceptionWhenContainerReturnSomethingDifferentThanApiRequestInterface()
    {
        // Expect
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(sprintf('Container identifier "@Ifrost\ApiBundle\Messenger\MessageHandlerInterface" is not instance of %s', MessageHandlerInterface::class));

        // Given
        $controller = new ApiControllerVariant();
        $controller->addInvalidMessageHandlerToContainer();

        // When & Then
        $controller->handle(new SampleCommand('summer'));
    }
}
