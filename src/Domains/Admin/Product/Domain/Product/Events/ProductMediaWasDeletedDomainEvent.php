<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductMediaWasDeletedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $mediaUuid,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $id,
        array $body,
        string $eventId,
        string $occurredOn,
    ): self {
        [
            'media_uuid' => $mediaUuid,
        ] = $body;

        return new self($id, $mediaUuid, $eventId, $occurredOn);
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
                'media_uuid' => $this->mediaUuid,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
