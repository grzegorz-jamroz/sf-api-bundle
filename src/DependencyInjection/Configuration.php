<?php
declare(strict_types=1);

namespace Ifrost\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('ifrost_api');

        $treeBuilder->getRootNode()
            ->children()
            ->booleanNode('api_request')->defaultValue(true)->end()
            ->booleanNode('exception_listener')->defaultValue(true)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
