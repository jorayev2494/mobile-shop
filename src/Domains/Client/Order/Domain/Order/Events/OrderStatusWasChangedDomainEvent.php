<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Order\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class OrderStatusWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $status,
        $eventId = null,
        $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'status' => $status,
        ] = $body;

        return new self(
            $id,
            $status,
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'client_order.status.was.changed';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'status' => $this->status,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
