<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Category\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class CategoryWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $value,
        public readonly bool $isActive,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'value' => $value,
            'is_active' => $isActive,
        ] = $body;

        return new self($id, $value, $isActive, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin.category.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'value' => $this->value,
                'is_active' => $this->isActive,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
