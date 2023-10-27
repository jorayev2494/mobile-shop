<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Category\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class CategoryIsActiveWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly bool $isActive,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'is_active' => $isActive,
        ] = $body;

        return new self($id, $isActive, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_category.is_active.was.changed';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'is_active' => $this->isActive,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
