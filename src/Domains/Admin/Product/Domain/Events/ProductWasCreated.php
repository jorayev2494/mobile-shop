<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Events;

use Project\Domains\Admin\Product\Domain\Product;
use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductWasCreated extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly Product $product,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['name'], $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin.product.was_created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'product' => $this->product->toArray(),
        ];
    }
}
