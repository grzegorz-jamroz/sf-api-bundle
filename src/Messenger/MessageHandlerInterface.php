<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Messenger;

interface MessageHandlerInterface
{
    public function handle(object $command): void;
}
