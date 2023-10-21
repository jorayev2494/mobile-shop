<?php

declare(strict_types= 1);

namespace Project\Domains\Admin\Profile\Domain\Profile\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProfileAvatarWasChangedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly array $avatar,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): DomainEvent
    {
        [
            'avatar' => $avatar,
        ] = $body;

        return new self($id, $avatar, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin_profile.avatar.was.changed';
    }

    public function toArray()
    {
        return [
            'id' => $this->aggregateId(),
            'body' => [
                'avatar' => $this->avatar,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
