<?php

declare(strict_types= 1);

namespace Project\Domains\Admin\Profile\Domain\Profile\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProfileLastNameWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $lastName,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'last_name' => $lastName,
        ] = $body;

        return new self($id, $lastName, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_profile.last_name.was.changed';
    }

    public function toArray()
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'last_name' => $this->lastName,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
