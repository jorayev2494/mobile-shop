<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductCategoryWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $categoryUuid,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'category_uuid' => $categoryUuid,
        ] = $body;

        return new self($id, $categoryUuid, $eventId, $occurredOn);        
    }

    public static function eventName(): string
    {
        return 'admin_product.category.was.changed';
    }

    public function toArray(): array
    {
        return [
            'uuid'=> $this->uuid,
            'body' => [
                'category_uuid' => $this->categoryUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
