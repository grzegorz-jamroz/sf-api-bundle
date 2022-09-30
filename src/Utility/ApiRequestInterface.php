<?php

declare(strict_types=1);

namespace Ifrost\ApiBundle\Utility;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ApiRequestInterface
{
    /**
     * @return array<string|int, mixed>
     */
    public function getData(): array;

    /**
     * @param array<int, string> $params
     *
     * @return array<string, mixed>
     */
    public function getSelectedData(array $params): array;

    public function getField(string $key): mixed;

    /**
     * @throws BadRequestException
     */
    public function getRequiredField(string $key): mixed;

    public function getFile(string $name): ?UploadedFile;

    public function getRequiredFile(string $key): UploadedFile;

    /**
     * @param array<int, string> $params
     *
     * @return array<string, mixed>
     */
    public function getRequest(array $params, bool $allowNullable = true): array;

    public function getAttribute(string $key, mixed $default = null): mixed;
}
