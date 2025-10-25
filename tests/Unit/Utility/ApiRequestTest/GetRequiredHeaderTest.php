<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Utility\ApiRequestTest;

use Ifrost\ApiBundle\Tests\Variant\Utility\ApiRequestVariant;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class GetRequiredHeaderTest extends TestCase
{
    public function testShouldReturnHeaderValueWhenItExists(): void
    {
        // Given
        $request = new Request();
        $request->headers->set('special', '123');
        $apiRequest = new ApiRequestVariant($request);

        // When & Then
        $this->assertEquals('123', $apiRequest->getRequiredHeader('special'));
    }

    public function testShouldThrowBadRequestExceptionWhenHeaderIsMissing(): void
    {
        // Given
        $request = new Request();
        $apiRequest = new ApiRequestVariant($request);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Missing header "special".');

        // When & Then
        $apiRequest->getRequiredHeader('special');
    }
}
