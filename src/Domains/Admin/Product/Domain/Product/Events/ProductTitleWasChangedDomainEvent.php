<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductTitleWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'title' => $title,
        ] = $body;

        return new self($id, $title, $eventId, $occurredOn);        
    }

    public static function eventName(): string
    {
        return 'admin_product.title.was.changed';
    }

    public function toArray(): array
    {
        return [
            'uuid'=> $this->uuid,
            'body' => [
                'title' => $this->title,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
