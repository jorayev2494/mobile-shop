<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Domain\Card\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class CardWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $authorUuid,
        public readonly string $type,
        public readonly string $holderName,
        public readonly string $number,
        public readonly int $cvv,
        public readonly string $expirationDate,
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
            'type' => $type,
            'holder_name' => $holderName,
            'number' => $number,
            'cvv' => $cvv,
            'expiration_date' => $expirationDate,
        ] = $body;

        return new self($uuid, $authorUuid, $type, $holderName, $number, $cvv, $expirationDate, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'client_card.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'uuid' => $this->uuid,
                'author_uuid' => $this->authorUuid,
                'type' => $this->type,
                'holder_name' => $this->holderName,
                'number' => $this->number,
                'cvv' => $this->cvv,
                'expiration_date' => $this->expirationDate,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
