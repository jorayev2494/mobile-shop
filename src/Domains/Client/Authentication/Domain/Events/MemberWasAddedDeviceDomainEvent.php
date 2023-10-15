<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class MemberWasAddedDeviceDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $authorUuid,
        public string $deviceId,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'uuid' => $uuid,
            'author_uuid' => $authorUuid,
            'device_id' => $deviceId,
        ] = $body;

        return new self($uuid, $authorUuid, $deviceId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'member.was.added.device';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'uuid' => $this->uuid,
                'author_uuid' => $this->authorUuid,
                'device_id' => $this->deviceId,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
