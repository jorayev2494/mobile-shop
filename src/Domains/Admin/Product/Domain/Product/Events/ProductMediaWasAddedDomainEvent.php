<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductMediaWasAddedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly array $data,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $id,
        array $body,
        string $eventId,
        string $occurredOn,
    ): self {
        return new self($id, $body, $eventId, $occurredOn);
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
