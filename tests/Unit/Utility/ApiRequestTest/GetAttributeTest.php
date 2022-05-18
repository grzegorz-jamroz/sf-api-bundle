<?php
declare(strict_types=1);

namespace Tests\Unit\Utility\ApiRequestTest;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Tests\Variant\Utility\ApiRequestVariant;

class GetAttributeTest extends TestCase
{
    public function testShouldReturnDefaultValueWhenAttributeDoesNotExist(): void
    {
        // Given
        $apiRequest = new ApiRequestVariant();

        // When & Then
        $this->assertEquals('green', $apiRequest->getAttribute('color', 'green'));
    }

    public function testShouldReturnNullWhenAttributeDoesNotExistAndNoDefaultValueSet(): void
    {
        // Given
        $apiRequest = new ApiRequestVariant();

        // When & Then
        $this->assertNull($apiRequest->getAttribute('color'));
    }

    public function testShouldReturnAttributeValueWhenItExists(): void
    {
        // Given
        $request = new Request([], [], ['color' => 'blue']);
        $apiRequest = new ApiRequestVariant($request);

        // When & Then
        $this->assertEquals('blue', $apiRequest->getAttribute('color', 'green'));
    }
}
