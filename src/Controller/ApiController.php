<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Controller;

use Ifrost\ApiBundle\Messenger\MessageHandlerInterface;
use Ifrost\ApiBundle\Utility\ApiRequestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApiController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'ifrost_api.api_request' => '?' . ApiRequestInterface::class,
        ]);
    }

    protected function handle(object $message): void
    {
        $this->getMessageHandler()->handle($message);
    }

    protected function getApiRequestService(): ApiRequestInterface
    {
        $apiRequest = $this->container->get('ifrost_api.api_request');
        $apiRequest instanceof ApiRequestInterface ?: throw new RuntimeException(sprintf('Container identifier "ifrost_api.api_request" is not instance of %s', ApiRequestInterface::class));

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

    protected function getMessageHandler(): MessageHandlerInterface
    {
        $eventDispatcher = $this->container->get('@Ifrost\ApiBundle\Messenger\MessageHandlerInterface');
        $eventDispatcher instanceof MessageHandlerInterface ?: throw new RuntimeException(sprintf('Container identifier "@Ifrost\ApiBundle\Messenger\MessageHandlerInterface" is not instance of %s', MessageHandlerInterface::class));

        return $eventDispatcher;
    }
}
