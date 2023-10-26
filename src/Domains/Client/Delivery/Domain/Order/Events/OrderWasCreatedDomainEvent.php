<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Order\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class OrderWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $status,
        // public readonly int $quantity,
        // public readonly float $sum,
        ?string $eventId = null,
        ?string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'status' => $status,
            // 'quantity' => $quantity,
            // 'sum' => $sum,
        ] = $body;

        return new self(
            $id,
            $status,
            // $quantity,
            // $sum,
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'client_delivery_order.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'status' => $this->status,
                // 'quantity' => $this->quantity,
                // 'sum' => $this->sum,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
