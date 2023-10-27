<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class ManagerWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly ?int $phone,
        public readonly ?int $roleId,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'role_id' => $roleId,
        ] = $body;

        return new self($id, $firstName, $lastName, $email, $phone, $roleId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_manager.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'phone' => $this->phone,
                'role_id' => $this->roleId,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
