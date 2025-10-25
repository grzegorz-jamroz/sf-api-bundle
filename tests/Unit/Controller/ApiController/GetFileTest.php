<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Controller\ApiController;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Ifrost\ApiBundle\Tests\Variant\Controller\ApiControllerVariant;

class GetFileTest extends TestCase
{
    public function testShouldReturnNull(): void
    {
        // Given
        $controller = new ApiControllerVariant();

        // When & Then
        $this->assertNull($controller->getFile('coverImage'));
    }

    public function testShouldReturnFile(): void
    {
        // Given
        $file = new UploadedFile(sprintf('%s/image/cover-image.png', TESTS_DATA_DIRECTORY), 'cover-image.png');
        $request = new Request([], [], [], [], ['coverImage' => $file]);
        $controller = new ApiControllerVariant($request);

        // When & Then
        $this->assertInstanceOf(UploadedFile::class, $controller->getFile('coverImage'));
    }
}
