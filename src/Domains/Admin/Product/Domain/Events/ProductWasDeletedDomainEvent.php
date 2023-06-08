<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class ProductWasDeletedDomainEvent extends DomainEvent
{

    public function __construct(
        public readonly string $uuid,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $aggregateId, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        return new self($aggregateId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'product.was.deleted';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
} 
