<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Routing\AnnotatedRouteActionLoader;

use Ifrost\ApiBundle\Routing\AnnotatedRouteActionLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;

class LoadTest extends TestCase
{
    public function testShouldReturnEmptyCollectionWhenGivenResourceIsNotString(): void
    {
        // Expect & Given
        $resource = [];
        $type = 'ifrost_api';
        $loader = new AnnotatedRouteActionLoader(
            new FileLocator(),
        );

        // When
        $collection = $loader->load($resource, $type);

        // Then
        $this->assertCount(0, $collection);
    }

    public function testShouldReturnEmptyCollectionWhenGivenResourceIsNotDirectory(): void
    {
        // Expect & Given
        $resource = sprintf('%s/tests/Variant/Action/SendContactMessageAction.php', ABSPATH);
        $type = 'ifrost_api';
        $loader = new AnnotatedRouteActionLoader(
            new FileLocator(),
        );

        // When
        $collection = $loader->load($resource, $type);

        // Then
        $this->assertCount(0, $collection);
    }

    public function testShouldReturnCollectionWithOneAction(): void
    {
        // Expect & Given
        $resource = sprintf('%s/tests/Variant/Action/', ABSPATH);
        $type = 'ifrost_api';
        $loader = new AnnotatedRouteActionLoader(
            new FileLocator(),
        );
        
        // When
        $collection = $loader->load($resource, $type);

        // Then
        $this->assertCount(1, $collection);
    }

    public function testShouldThrowInvalidArgumentExceptionWhenFoundFileWithoutPhpCode(): void
    {
        // Expect & Given
        $fileName = 'InvalidActionWithoutPhpCode.php';
        $resource = sprintf('%s/tests/Variant/Action/', ABSPATH);
        $filename = sprintf('%s%s', $resource, $fileName);
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('The file "%s" does not contain PHP code. Did you forgot to add the "<?php" start tag at the beginning of the file?', $filename));
        file_exists($filename) ? unlink($filename) : null;
        copy(sprintf('%s/%s', TESTS_DATA_DIRECTORY, $fileName), $filename);
        $type = 'ifrost_api';
        $loader = new AnnotatedRouteActionLoader(
            new FileLocator(),
        );

        try {
            // When
            $loader->load($resource, $type);
        } finally {
            // Then
            file_exists($filename) ? unlink($filename) : null;
        }
    }
}
