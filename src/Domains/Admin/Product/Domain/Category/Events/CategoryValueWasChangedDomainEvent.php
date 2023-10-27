<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Category\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class CategoryValueWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $value,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'value' => $value,
        ] = $body;

        return new self($id, $value, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_category.value.was.changed';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'value' => $this->value,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
