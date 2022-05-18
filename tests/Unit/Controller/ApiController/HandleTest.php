<?php

declare(strict_types=1);

namespace Tests\Unit\Controller\ApiController;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\Messenger\MessageBusInterface;
use Tests\Variant\Controller\ApiControllerVariant;
use Tests\Variant\Messenger\Command\SampleCommand;

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
        $this->expectExceptionMessage(sprintf('Container identifier "messenger.default_bus" is not instance of %s', MessageBusInterface::class));

        // Given
        $controller = new ApiControllerVariant();
        $controller->addInvalidMessageBusToContainer();

        // When & Then
        $controller->handle(new SampleCommand('summer'));
    }

    public function testShouldThrowLogicExceptionWhenContainerReturnSomethingDifferentThanApiRequestInterface()
    {
        // Expect
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('The message bus is not enabled in your application. You need to define the "messenger.default_bus" configuration option.');

        // Given
        $controller = new ApiControllerVariant();

        // When & Then
        $controller->handle(new SampleCommand('summer'));
    }
}
