<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\Contracts;

interface LocatorInterface
{
    public function all(): array;
}
