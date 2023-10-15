<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Authorization;

use DomainException;
use Project\Shared\Application\AuthorizationInterface;

final class Authorization implements AuthorizationInterface
{
    private array $role;
    private array $permissions;

    public function __construct()
    {
        $this->role = \Auth::payload()->get('role');
        ['permissions' => $this->permissions] = $this->role;
    }

    public function hasPermission(string $value): bool
    {
        return in_array($value, array_column($this->permissions, 'value'), true);
    }

    public function checkPermission(string $value): void
    {
        if (! $this->hasPermission($value)) {
            throw new DomainException('cant_permission');
        }
    }
}
