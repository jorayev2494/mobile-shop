<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Events;

use Project\Domains\Admin\Role\Domain\Role;
use Project\Shared\Domain\Bus\Event\DomainEvent;

class RoleCreatedEvent extends DomainEvent
{
    public const TYPE = 'role_created_event';

    public function __construct(
        private readonly Role $role
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'role' => $this->role->toArray(),
        ];
    }
}
