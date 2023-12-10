<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Order\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class OrderProductWasAddedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $productUuid,
        public readonly int $quantity,

        public ?string $eventId = null,
        public ?string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'product_uuid' => $productUuid,
            'quantity' => $quantity,
        ] = $body;
        
        return new self($id, $productUuid, $quantity, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'client_order.product.was.added';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'product_uuid' => $this->productUuid,
                'quantity' => $this->quantity,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
