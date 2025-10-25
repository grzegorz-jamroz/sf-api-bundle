<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Utility\ApiRequestTest;

use Ifrost\ApiBundle\Tests\Variant\Utility\ApiRequestVariant;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class GetRequiredAttributeTest extends TestCase
{
    public function testShouldReturnAttributeValueWhenItExists(): void
    {
        // Given
        $request = new Request(attributes: ['color' => 'blue']);
        $apiRequest = new ApiRequestVariant($request);

        // When & Then
        $this->assertEquals('blue', $apiRequest->getRequiredAttribute('color'));
    }

    public function testShouldThrowBadRequestExceptionWhenAttributeDoesNotExist(): void
    {
        // Expect & Given
        $key = 'birthday';
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage(sprintf('Missing attribute "%s".', $key));
        $apiRequest = new ApiRequestVariant();
        
        // When & Then
        $apiRequest->getRequiredAttribute($key);
    }
}
