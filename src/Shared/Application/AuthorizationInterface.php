<?php

declare(strict_types=1);

namespace Project\Shared\Application;

interface AuthorizationInterface
{
    public function hasPermission(string $value): bool;
    public function checkPermission(string $value): void;
}
