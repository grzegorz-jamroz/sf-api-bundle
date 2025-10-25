<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Utility\ApiRequestTest;

use PHPUnit\Framework\TestCase;
use Ifrost\ApiBundle\Tests\Variant\Utility\ApiRequestVariant;

class SetDataTest extends TestCase
{
    public function testShouldSetEmptyArray()
    {
        // Given
        $apiRequest = new ApiRequestVariant();

        // When
        $apiRequest->setData([]);

        // Then
        $this->assertEquals([], $apiRequest->getData());
    }

    public function testShouldSetArrayWithData()
    {
        // Given
        $apiRequest = new ApiRequestVariant();
        $expected = ['name' => 'Guitar'];

        // When
        $apiRequest->setData($expected);

        // Then
        $this->assertEquals($expected, $apiRequest->getData());
    }
}
