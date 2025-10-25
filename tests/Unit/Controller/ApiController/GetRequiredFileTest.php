<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Controller\ApiController;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Ifrost\ApiBundle\Tests\Variant\Controller\ApiControllerVariant;

class GetRequiredFileTest extends TestCase
{
    public function testShouldReturnFile(): void
    {
        // Given
        $file = new UploadedFile(sprintf('%s/image/cover-image.png', TESTS_DATA_DIRECTORY), 'cover-image.png');
        $request = new Request([], [], [], [], ['coverImage' => $file]);
        $controller = new ApiControllerVariant($request);

        // When & Then
        $this->assertInstanceOf(UploadedFile::class, $controller->getRequiredFile('coverImage'));
    }

    public function testShouldThrowBadRequestExceptionWhenFileDoesNotExist(): void
    {
        // Expect & Given
        $key = 'coverImage';
        $controller = new ApiControllerVariant();
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage(sprintf('Missing parameter "%s" with file data.', $key));

        // When & Then
        $controller->getRequiredFile($key);
    }
}
