<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Unit\Traits;

use Ifrost\ApiBundle\Tests\Variant\Action\ProductCreateAction;
use Ifrost\ApiBundle\Tests\Variant\FindClassTraitUser;
use PHPUnit\Framework\TestCase;

class WithFindClassTraitTest extends TestCase
{
    public function testShouldReturnFalseWhenThereIsNoClassInTheFile()
    {
        // Given
        $finder = new FindClassTraitUser();
        $file = sprintf('%s/FileWithoutClass.php', TESTS_DATA_DIRECTORY);

        // When & Then
        $this->assertFalse($finder->find($file));
    }

    public function testShouldReturnFalseForFileWithAnonymousClass()
    {
        // Given
        $finder = new FindClassTraitUser();
        $file = sprintf('%s/FileWithAnonymousClass.php', TESTS_DATA_DIRECTORY);

        // When & Then
        $this->assertFalse($finder->find($file));
    }

    public function testShouldReturnFalseForFileWithClassConstantUsage()
    {
        // Given
        $finder = new FindClassTraitUser();
        $file = sprintf('%s/FileWithClassConstant.php', TESTS_DATA_DIRECTORY);

        // When & Then
        $this->assertFalse($finder->find($file));
    }

    public function testShouldFindClassNameForGivenFile()
    {
        // Given
        $finder = new FindClassTraitUser();
        $file = sprintf('%s/../../Variant/Action/ProductCreateAction.php', __DIR__);

        // When & Then
        $this->assertEquals(ProductCreateAction::class, $finder->find($file));
    }

    public function testShouldReturnFalseForGivenFile()
    {
        // Given
        $finder = new FindClassTraitUser();
        $file = sprintf('%s/EmptyFileClass.php', TESTS_DATA_DIRECTORY);

        // When & Then
        $this->assertFalse($finder->find($file));
    }
}


