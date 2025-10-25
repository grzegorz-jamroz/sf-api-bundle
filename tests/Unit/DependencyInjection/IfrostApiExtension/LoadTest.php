<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\DependencyInjection\IfrostApiExtension;

use Ifrost\ApiBundle\DependencyInjection\Configuration;
use Ifrost\ApiBundle\DependencyInjection\IfrostApiExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LoadTest extends TestCase
{
    public function testShouldReturnConfiguration()
    {
        // When & Then
        $this->assertInstanceOf(Configuration::class, (new IfrostApiExtension())->getConfiguration([], new ContainerBuilder()));
    }
}
