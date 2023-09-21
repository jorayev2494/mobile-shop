<?php

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductMediaWasDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $mediaId,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $uuid,
        array $body,
        string $eventId,
        string $occurredOn,
    ): self
    {
        [
            'product_uuid' => $uuid,
            'media_id' => $mediaId,
        ] = $body;

        return new self($uuid, $mediaId, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'product_media.was.deleted';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'product_uuid' => $this->uuid,
                'media_id' => $this->mediaId,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
