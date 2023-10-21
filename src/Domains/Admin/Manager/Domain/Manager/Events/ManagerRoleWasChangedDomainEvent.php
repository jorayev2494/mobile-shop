<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class ManagerRoleWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly ?int $roleId,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'role_id' => $roleId,
        ] = $body;

        return new self($id, $roleId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_manager.role_id.was.changed';
    }

    public function toArray()
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'role_id' => $this->roleId,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn()
        ];
    }
}
