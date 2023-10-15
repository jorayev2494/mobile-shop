<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Domain\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class AddressWasDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        // [
            
        // ] = $body;

        return new self($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'client_address.was.deleted';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [

            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
