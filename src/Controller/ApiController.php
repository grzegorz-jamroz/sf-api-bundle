<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Controller;

use Ifrost\ApiBundle\Utility\ApiRequest;
use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

class ApiController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'app.api_request' => '?' . ApiRequest::class,
            'messenger.default_bus' => '?' . MessageBusInterface::class,
        ]);
    }

    protected function handle(object $message): void
    {
        try {
            $this->dispatchMessage($message);
        } catch (\Exception $e) {
            if (
                $e instanceof HandlerFailedException
                && $e->getPrevious() !== null
            ) {
                throw $e->getPrevious();
            }

            throw $e;
        }
    }

    protected function getApiRequestService(): ApiRequestInterface
    {
        $apiRequest = $this->container->get('app.api_request');
        $apiRequest instanceof ApiRequestInterface ?: throw new RuntimeException(sprintf('Container identifier "app.api_request" is not instance of %s', ApiRequestInterface::class));

        return $apiRequest;
    }

    /**
     * @param array<int, string> $params
     *
     * @return array<string, mixed>
     */
    protected function getApiRequest(array $params, bool $allowNullable = true): array
    {
        $apiRequest = $this->getApiRequestService();

        return $apiRequest->getRequest($params, $allowNullable);
    }

    protected function getFile(string $key): ?UploadedFile
    {
        return $this->getApiRequestService()->getFile($key);
    }

    protected function getRequiredFile(string $key): UploadedFile
    {
        return $this->getApiRequestService()->getRequiredFile($key);
    }

    protected function getField(string $key): mixed
    {
        return $this->getApiRequest([$key])[$key];
    }

    protected function getRequiredField(string $key): mixed
    {
        return $this->getApiRequestService()->getRequiredField($key);
    }

    /**
     * Dispatches a message to the bus.
     *
     * @param object                     $message The message or the message pre-wrapped in an envelope
     * @param array<int, StampInterface> $stamps
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function dispatchMessage(object $message, array $stamps = []): Envelope
    {
        if (!$this->container->has('messenger.default_bus')) {
            $message = class_exists(Envelope::class) ? 'You need to define the "messenger.default_bus" configuration option.' : 'Try running "composer require symfony/messenger".';
            throw new \LogicException('The message bus is not enabled in your application. ' . $message);
        }

        $bus = $this->container->get('messenger.default_bus');
        $bus instanceof MessageBusInterface ?: throw new RuntimeException(sprintf('Container identifier "messenger.default_bus" is not instance of %s', MessageBusInterface::class));

        return $bus->dispatch($message, $stamps);
    }
}
