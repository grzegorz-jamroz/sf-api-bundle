<?php
declare(strict_types=1);

namespace DependencyInjection\IfrostApiExtension;

use Ifrost\ApiBundle\DependencyInjection\IfrostApiExtension;
use Ifrost\ApiBundle\EventListener\ExceptionListener;
use Ifrost\ApiBundle\Utility\ApiRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GetConfigurationTest extends TestCase
{
    public function testShouldNotLoadAnyConfigs()
    {
        // Given
        $configs = [
            'ifrost_api' => [
                'api_request' => false,
                'exception_listener' => false,
            ],
        ];
        $containerBuilder = new ContainerBuilder();

        // When
        (new IfrostApiExtension())->load($configs, $containerBuilder);

        // Then
        $this->assertFalse($containerBuilder->hasDefinition(ApiRequest::class));
        $this->assertFalse($containerBuilder->hasDefinition(ExceptionListener::class));
    }

    public function testShouldLoadAllConfigs()
    {
        // Given
        $configs = [
            'ifrost_api' => [
                'api_request' => true,
                'exception_listener' => true,
            ],
        ];
        $containerBuilder = new ContainerBuilder();

        // When
        (new IfrostApiExtension())->load($configs, $containerBuilder);

        // Then
        $this->assertTrue($containerBuilder->hasDefinition(ApiRequest::class));
        $this->assertTrue($containerBuilder->hasDefinition(ExceptionListener::class));
    }
}
