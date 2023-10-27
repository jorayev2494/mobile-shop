<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductPriceWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly float $price,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'price' => $price,
        ] = $body;

        return new self($id, $price, $eventId, $occurredOn);        
    }

    public static function eventName(): string
    {
        return 'admin_product.price.was.changed';
    }

    public function toArray(): array
    {
        return [
            'uuid'=> $this->uuid,
            'body' => [
                'price' => $this->price,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
