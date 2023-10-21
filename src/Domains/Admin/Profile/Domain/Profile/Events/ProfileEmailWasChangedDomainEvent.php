<?php

declare(strict_types= 1);

namespace Project\Domains\Admin\Profile\Domain\Profile\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProfileEmailWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $email,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'email' => $email,
        ] = $body;

        return new self($id, $email, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_profile.email.was.changed';
    }

    public function toArray()
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'email' => $this->email,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
