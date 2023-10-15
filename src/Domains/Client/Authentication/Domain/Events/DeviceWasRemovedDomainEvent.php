<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class DeviceWasRemovedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $authorUuid,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $id,
        array $body,
        string $eventId,
        string $occurredOn,
    ): self {
        [
            'uuid' => $uuid,
            'author_uuid' => $authorUuid,
        ] = $body;

        return new self($uuid, $authorUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'client.authentication.device.was.deleted';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'author_uuid' => $this->authorUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
