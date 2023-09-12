<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $aggregateId,
        public readonly array $data,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $data,
        string $eventId,
        string $occurredOn
    ): self {
        return new self($aggregateId, $data, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'product.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => $this->data,
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
