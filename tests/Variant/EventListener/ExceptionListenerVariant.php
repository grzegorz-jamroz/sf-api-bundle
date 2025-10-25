<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Tests\Variant\EventListener;

use Ifrost\ApiBundle\EventListener\ExceptionListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Ifrost\ApiBundle\Tests\Variant\HttpKernelVariant;

class ExceptionListenerVariant extends ExceptionListener
{
    private ?ExceptionEvent $event;

    public function onKernelExceptionVariant(\Throwable $exception): void
    {
        $this->event = new ExceptionEvent(new HttpKernelVariant(), new Request(), HttpKernelInterface::MAIN_REQUEST, $exception);

        parent::onKernelException($this->event);
    }

    public function getEvent(): ?ExceptionEvent
    {
        return $this->event;
    }
}
