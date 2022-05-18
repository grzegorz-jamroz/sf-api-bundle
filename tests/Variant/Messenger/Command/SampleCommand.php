<?php
declare(strict_types=1);

namespace Tests\Variant\Messenger\Command;

class SampleCommand
{
    public function __construct(private string $name)
    {}

    public function getName(): string
    {
        return $this->name;
    }
}
