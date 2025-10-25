<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Utility\ApiRequestTest;

use Ifrost\ApiBundle\Tests\Variant\Utility\ApiRequestVariant;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class GetRequiredCookieTest extends TestCase
{
    public function testShouldReturnCookieValueWhenItExists(): void
    {
        // Given
        $request = new Request([], [], [], ['special' => '123']);
        $apiRequest = new ApiRequestVariant($request);

        // When & Then
        $this->assertEquals('123', $apiRequest->getRequiredCookie('special'));
    }

    public function testShouldThrowBadRequestExceptionWhenCookieIsMissing(): void
    {
        // Given
        $request = new Request();
        $apiRequest = new ApiRequestVariant($request);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Missing cookie "special".');

        // When & Then
        $apiRequest->getRequiredCookie('special');
    }
}
