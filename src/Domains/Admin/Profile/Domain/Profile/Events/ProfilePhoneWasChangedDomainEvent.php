<?php

declare(strict_types= 1);

namespace Project\Domains\Admin\Profile\Domain\Profile\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProfilePhoneWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly ?string $phone,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'phone' => $phone,
        ] = $body;

        return new self($id, $phone, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_profile.phone.was.changed';
    }

    public function toArray()
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'phone' => $this->phone,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
