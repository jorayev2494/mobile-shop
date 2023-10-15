<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Domain\Profile\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class ProfileFirstNameWasUpdatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly ?string $firstName,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'uuid' => $uuid,
            'first_name' => $firstName,
        ] = $body;

        return new self($uuid, $firstName, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'profile.first_name.was.updated';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'uuid' => $this->uuid,
                'first_name' => $this->firstName,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
