<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\DependencyInjection\Configuration;

use Ifrost\ApiBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class GetConfigTreeBuilderTest extends TestCase
{
    public function testShouldReturnDefaultTreeBuilder()
    {
        // Given
        $children = ['api_request', 'exception_listener'];
        $treeBuilder = (new Configuration())->getConfigTreeBuilder();

        // When & Then
        foreach ($children as $child) {
            $definition = $treeBuilder->getRootNode()->find($child);
            $this->assertInstanceOf(NodeDefinition::class, $definition);
        }
    }
}
