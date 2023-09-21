<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        public readonly string $categoryUuid,
        public readonly array $price,
        public readonly int $viewedCount,
        public readonly string $description,
        public readonly bool $isActive,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $data,
        string $eventId,
        string $occurredOn
    ): self {

        [
            'uuid' => $uuid,
            'title' => $title,
            'category_uuid' => $categoryUuid,
            'price' => $price,
            'viewed_count' => $viewedCount,
            'description' => $description,
            'is_active' => $isActive,
        ] = $data;

        return new self($uuid, $title, $categoryUuid, $price, $viewedCount, $description, $isActive, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'product.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'title' => $this->title,
                'category_uuid' => $this->categoryUuid,
                'price' => $this->price,
                'viewed_count' => $this->viewedCount,
                'description' => $this->description,
                'is_active' => $this->isActive,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
