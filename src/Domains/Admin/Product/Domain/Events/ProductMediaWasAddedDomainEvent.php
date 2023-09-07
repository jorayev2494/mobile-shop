<?php

namespace Project\Domains\Admin\Product\Domain\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductMediaWasAddedDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        public readonly array $data,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn,
    ): self
    {
        return new self($aggregateId, $body, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'product_media.was.added';
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
