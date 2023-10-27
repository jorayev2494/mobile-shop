<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Category\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class CategoryWasDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        string $eventId = null,
        string $occurredOn = null,
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        return new self($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_category.was.deleted';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [

            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
