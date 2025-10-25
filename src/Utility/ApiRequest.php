<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Utility;

use PlainDataTransformer\Transform;
use RuntimeException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiRequest implements ApiRequestInterface
{
    private Request $request;

    /**
     * @var array<string|int, mixed>|null
     */
    private ?array $data = null;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest() ?? throw new RuntimeException('Unable to get Current Request');
    }

    public function getData(): array
    {
        if ($this->data !== null) {
            return $this->data;
        }

        $body = json_decode(Transform::toString($this->request->getContent()), true);
        $this->data = array_merge(
            Transform::toArray($this->request->query->all()),
            Transform::toArray($this->request->request->all()),
            Transform::toArray($body),
        );

        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getSelectedData(array $params): array
    {
        $data = $this->getData();
        $output = [];

        foreach ($params as $param) {
            $output[$param] = $data[$param] ?? null;
        }

        return $output;
    }

    public function getField(string $key, mixed $default = null): mixed
    {
        return $this->getRequest([$key])[$key] ?? $this->getHeader($key) ?? $this->getCookie($key) ?? $default;
    }

    public function getRequiredField(string $key): mixed
    {
        $value = $this->getField($key);

        if ($value === null) {
            throw new BadRequestException(sprintf('Missing parameter "%s".', $key));
        }

        return $value;
    }

    public function getFile(string $name): ?UploadedFile
    {
        $file = $this->request->files->get($name);

        return $file instanceof UploadedFile ? $file : null;
    }

    public function getRequiredFile(string $key): UploadedFile
    {
        $file = $this->getFile($key);

        if ($file === null) {
            throw new BadRequestException(sprintf('Missing parameter "%s" with file data.', $key));
        }

        return $file;
    }

    public function getRequest(
        array $params,
        bool $allowNullable = true,
    ): array {
        $data = $this->getSelectedData($params);

        if ($allowNullable) {
            return $data;
        }

        return array_filter($data, fn ($item) => $item !== null);
    }

    public function getAttribute(string $key, mixed $default = null): mixed
    {
        return $this->request->attributes->get($key, $default);
    }

    public function getRequiredAttribute(string $key): mixed
    {
        $value = $this->getAttribute($key);

        if ($value === null) {
            throw new BadRequestException(sprintf('Missing attribute "%s".', $key));
        }

        return $value;
    }

    public function getHeader(string $key, mixed $default = null): mixed
    {
        return $this->request->headers->get($key, $default);
    }

    /**
     * @throws BadRequestException
     */
    public function getRequiredHeader(string $key): mixed
    {
        $value = $this->getHeader($key);

        if ($value === null) {
            throw new BadRequestException(sprintf('Missing header "%s".', $key));
        }

        return $value;
    }

    public function getCookie(string $key, mixed $default = null): mixed
    {
        return $this->request->cookies->get($key, $default);
    }

    /**
     * @throws BadRequestException
     */
    public function getRequiredCookie(string $key): mixed
    {
        $value = $this->getCookie($key);

        if ($value === null) {
            throw new BadRequestException(sprintf('Missing cookie "%s".', $key));
        }

        return $value;
    }
}
