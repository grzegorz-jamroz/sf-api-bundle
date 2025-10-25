<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Variant;

use Ifrost\ApiBundle\Traits\WithFindClassTrait;

class FindClassTraitUser
{
    use WithFindClassTrait;

    public function find(string|\SplFileInfo $file): string|false
    {
        return $this->findClass($file);
    }
}
