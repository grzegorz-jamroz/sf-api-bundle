<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\DependencyInjection;

use PlainDataTransformer\Transform;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class IfrostApiExtension extends Extension
{
    /**
     * @param array<mixed, mixed> $configs
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config'),
        );
        $loader->load('services.yaml');

        if (Transform::toBool($config['api_request'])) {
            $loader->load('api_request.yaml');
        }

        if (Transform::toBool($config['exception_listener'])) {
            $loader->load('exception_listener.yaml');
        }
    }

    /**
     * @param array<string, mixed> $config
     */
    public function getConfiguration(array $config, ContainerBuilder $container): ConfigurationInterface
    {
        return new Configuration();
    }
}
