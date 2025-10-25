<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Routing\AnnotatedRouteActionLoader;

use Ifrost\ApiBundle\Routing\AnnotatedRouteActionLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;

class SupportsTest extends TestCase
{
    public function testShouldReturnTrueWhenTypeMatch(): void
    {
        // Expect & Given
        $resource = '../src/Action/';
        $type = 'ifrost_api';
        $loader = new AnnotatedRouteActionLoader(
            new FileLocator(),
        );
        
        // When & Then
        $this->assertTrue($loader->supports($resource, $type));
    }

    public function testShouldReturnFalseWhenTypeDoesNotMatch(): void
    {
        // Expect & Given
        $resource = '.../src/Kernel.php';
        $type = 'attribute';
        $loader = new AnnotatedRouteActionLoader(
            new FileLocator(),
        );

        // When & Then
        $this->assertFalse($loader->supports($resource, $type));
    }
}
