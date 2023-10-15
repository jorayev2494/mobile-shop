<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Domain\Currency\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class CurrencyWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $value,
        public readonly bool $isActive,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            // 'uuid' => $uuid,
            'value' => $value,
            'is_active' => $isActive,
        ] = $body;

        return new self($id, $value, $isActive, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_currency.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                // 'uuid' => $this->uuid,
                'value' => $this->value,
                'is_active' => $this->isActive,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
