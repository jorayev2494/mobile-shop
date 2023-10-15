<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class MemberWasRegisteredDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $email,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $id,
        array $body,
        string $eventId,
        string $occurredOn
    ): self
    {
        [
            'uuid' => $uuid,
            'email' => $email,
        ] = $body;

        return new self($uuid, $email, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin.member.was.registered';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'uuid' => $this->uuid,
                'email' => $this->email,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
