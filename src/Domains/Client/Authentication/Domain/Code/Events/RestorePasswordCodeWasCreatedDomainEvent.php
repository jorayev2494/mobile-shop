<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Code\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

class RestorePasswordCodeWasCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        public string $uuid,
        public string $email,
        public int $code,
        $eventId = null,
        $occurredOn = null,
    )
    {
        parent::__construct($uuid, $eventId, $occurredOn);    
    }

    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'uuid' => $uuid,
            'email' => $email,
            'code' => $code,
        ] = $body;

        return new self($uuid, $email, $code, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'restore.password.code.was.created';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->uuid,
            'body' => [
                'uuid' => $this->uuid,
                'email' => $this->email,
                'code' => $this->code,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
