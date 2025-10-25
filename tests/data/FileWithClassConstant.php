<?php

declare(strict_types=1);

function someFunction(string $className)
{
    return $className;
}

someFunction(stdClass::class);

