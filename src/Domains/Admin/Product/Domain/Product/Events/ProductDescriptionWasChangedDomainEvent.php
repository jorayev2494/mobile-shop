<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductDescriptionWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $description,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'description' => $description,
        ] = $body;

        return new self($id, $description, $eventId, $occurredOn);        
    }

    public static function eventName(): string
    {
        return 'admin_product.description.was.changed';
    }

    public function toArray(): array
    {
        return [
            'uuid'=> $this->uuid,
            'body' => [
                'description' => $this->description,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
