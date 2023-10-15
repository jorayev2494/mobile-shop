<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Domain\Card\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class CardWasDeleteDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $authorUuid,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'uuid' => $uuid,
            'author_uuid' => $authorUuid,
        ] = $body;

        return new self($uuid, $authorUuid, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'client_card.was.deleted';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'uuid' => $this->uuid,
                'author_uuid' => $this->authorUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
