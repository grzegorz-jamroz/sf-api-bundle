<?php
declare(strict_types=1);

namespace Controller\ApiController;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Tests\Variant\Controller\ApiControllerVariant;

class GetRequiredFieldTest extends TestCase
{
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
        ];
        $requests = [
            new Request($data),
            new Request([], $data),
            new Request([], [], [], [], [], [], json_encode($data)),
        ];

        // When & Then
        foreach ($requests as $request) {
            $controller = new ApiControllerVariant($request);
            $this->assertEquals('red', $controller->getRequiredField('color'));
            $this->assertEquals(4, $controller->getRequiredField('number'));
            $this->assertEquals(1.2, $controller->getRequiredField('distance'));
            $this->assertEquals(['name' => 'Mark', 'country' => 'USA'], $controller->getRequiredField('user'));
            $this->assertEquals(true, $controller->getRequiredField('isActive'));
        }
    }

    public function testShouldThrowBadRequestExceptionWhenValueNotExist(): void
    {
        // Expect & Given
        $key = 'color';
        $controller = new ApiControllerVariant();
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage(sprintf('Missing parameter "%s".', $key));

        // When & Then
        $controller->getRequiredField($key);
    }

    public function testShouldThrowBadRequestExceptionWhenValueIsNull(): void
    {
        // Expect & Given
        $key = 'color';
        $request = new Request([], [], [], [], [], [], json_encode([$key => null]));
        $controller = new ApiControllerVariant($request);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage(sprintf('Missing parameter "%s".', $key));

        // When & Then
        $controller->getRequiredField($key);
    }
}
