<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

final class MemberRestorePasswordLinkWasAddedDomainEvent extends DomainEvent
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $token,
        public readonly string $email,
        string $eventId = null,
        string $occurredOn = null,
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): static
    {
        [
            'uuid' => $uuid,
            'token' => $token,
            'email' => $email,
        ] = $body;

        return new self($uuid, $token, $email, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'admin.authentication.member.was.added.restore_password_link';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'uuid' => $this->uuid,
                'token' => $this->token,
                'email' => $this->email,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
