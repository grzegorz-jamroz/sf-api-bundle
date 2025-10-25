<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Controller\ApiController;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Ifrost\ApiBundle\Tests\Variant\Controller\ApiControllerVariant;

class GetApiRequestTest extends TestCase
{
    public function testShouldReturnEmptyArray(): void
    {
        // Given
        $controller = new ApiControllerVariant();
        $params = ['name', 'color'];

        // When & Then
        $this->assertEquals([], $controller->getApiRequest($params, false));
    }

    public function testShouldReturnArrayWithNulls(): void
    {
        // Given
        $controller = new ApiControllerVariant();
        $params = ['name', 'color'];
        $expected = [
            'name' => null,
            'color' => null,
        ];

        // When & Then
        $this->assertEquals($expected, $controller->getApiRequest($params));
    }

    public function testShouldReturnArrayWithValues(): void
    {
        // Given
        $data = [
            'name' => 'Sam',
            'color' => 'red',
        ];
        $requests = [
            new Request($data),
            new Request([], $data),
            new Request(['name' => 'Sam'], ['color' => 'red']),
            new Request([], [], [], [], [], [], json_encode($data)),
            new Request(['name' => 'Sam'], [], [], [], [], [], json_encode(['color' => 'red'])),
            new Request([], ['name' => 'Sam'], [], [], [], [], json_encode(['color' => 'red'])),
        ];
        $params = ['name', 'color'];
        $expected = [
            'name' => 'Sam',
            'color' => 'red',
        ];

        // When & Then
        foreach ($requests as $request) {
            $controller = new ApiControllerVariant($request);
            $this->assertEquals($expected, $controller->getApiRequest($params));
        }
    }

    public function testShouldReturnArrayWithValueAndNull(): void
    {
        // Given
        $data = [
            'name' => 'Sam',
        ];
        $requests = [
            new Request($data),
            new Request([], $data),
            new Request([], [], [], [], [], [], json_encode($data)),
        ];
        $params = ['name', 'color'];
        $expected = [
            'name' => 'Sam',
            'color' => null,
        ];

        // When & Then
        foreach ($requests as $request) {
            $controller = new ApiControllerVariant($request);
            $this->assertEquals($expected, $controller->getApiRequest($params));
        }
    }
}
