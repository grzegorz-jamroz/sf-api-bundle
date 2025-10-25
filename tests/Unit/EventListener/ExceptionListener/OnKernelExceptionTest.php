<?php

declare(strict_types=1);

namespace EventListener\ExceptionListener;

use PHPUnit\Framework\TestCase;
use Ifrost\ApiBundle\Tests\Variant\EventListener\ExceptionListenerVariant;

class OnKernelExceptionTest extends TestCase
{
    public function testShouldReturnOriginalMessageInResponse(): void
    {
        // Given
        $exception = new \Exception('Sample exception occurred');
        $expected = [
            'message' => $exception->getMessage(),
            'exceptionClass' => 'Exception',
        ];
        $envs = ['dev', 'test'];

        // When & Then
        foreach ($envs as $env) {
            $_ENV['APP_ENV'] = $env;
            $exceptionListener = new ExceptionListenerVariant();
            $exceptionListener->onKernelExceptionVariant($exception);
            $this->assertEquals($expected, json_decode($exceptionListener->getEvent()->getResponse()->getContent(), true));
        }
    }

    public function testShouldReturnProductionMessageInResponse(): void
    {
        // Given
        $exception = new \Exception('Sample exception occurred');
        $expected = [
            'message' => 'Oops! An Error Occurred',
        ];
        $envs = ['prod', 'production'];

        // When & Then
        foreach ($envs as $env) {
            $_ENV['APP_ENV'] = $env;
            $exceptionListener = new ExceptionListenerVariant();
            $exceptionListener->onKernelExceptionVariant($exception);
            $this->assertEquals($expected, json_decode($exceptionListener->getEvent()->getResponse()->getContent(), true));
        }
    }

    public function testShouldReturnOriginalUnescapedMessageInResponse(): void
    {
        // Given
        $exception = new \Exception("Sample exception occurred with 'some expression' in \"quotes\".");
        $expected = [
            'message' => $exception->getMessage(),
            'exceptionClass' => 'Exception',
        ];
        $envs = ['dev', 'test'];

        // When & Then
        foreach ($envs as $env) {
            $_ENV['APP_ENV'] = $env;
            $exceptionListener = new ExceptionListenerVariant();
            $exceptionListener->onKernelExceptionVariant($exception);
            $this->assertEquals(json_encode($expected, JSON_UNESCAPED_UNICODE), $exceptionListener->getEvent()->getResponse()->getContent());
        }
    }
}
