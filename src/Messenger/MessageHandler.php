<?php
declare(strict_types=1);

namespace Ifrost\ApiBundle\Messenger;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageHandler implements MessageHandlerInterface
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function handle(object $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }
    }
}
