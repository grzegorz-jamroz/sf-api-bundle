<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Controller\ApiController;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Ifrost\ApiBundle\Tests\Variant\Controller\ApiControllerVariant;

class GetFieldTest extends TestCase
{
    public function testShouldReturnNull(): void
    {
        // Given
        $controller = new ApiControllerVariant();

        // When & Then
        $this->assertEquals(null, $controller->getField('color'));
    }

    public function testShouldReturnValue(): void
    {
        // Given
        $data = [
            'color' => 'red',
            'number' => 4,
            'distance' => 1.2,
            'user' => [
                'name' => 'Mark',
                'country' => 'USA',
            ],
            'isActive' => true,
            'key' => null,
        ];
        $requests = [
            new Request($data),
            new Request([], $data),
            new Request([], [], [], [], [], [], json_encode($data)),
        ];

        // When & Then
        foreach ($requests as $request) {
            $controller = new ApiControllerVariant($request);
            $this->assertEquals('red', $controller->getField('color'));
            $this->assertEquals(4, $controller->getField('number'));
            $this->assertEquals(1.2, $controller->getField('distance'));
            $this->assertEquals(['name' => 'Mark', 'country' => 'USA'], $controller->getField('user'));
            $this->assertEquals(true, $controller->getField('isActive'));
            $this->assertEquals(null, $controller->getField('type'));
            $this->assertEquals(null, $controller->getField('key'));
        }
    }
}
