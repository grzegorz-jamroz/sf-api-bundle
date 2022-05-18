<?php
declare(strict_types=1);

namespace Tests\Variant\Messenger\Handler;

use Tests\Variant\Messenger\Command\SampleCommand;

class SampleCommandHandler
{
    public function __invoke(SampleCommand $command): void
    {
        throw new \Exception(sprintf('This is test error. Given name - %s.', $command->getName()));
    }
}
