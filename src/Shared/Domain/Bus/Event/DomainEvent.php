<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Event;

use Project\Shared\Domain\ValueObject\UuidValueObject;

abstract class DomainEvent implements Event
{
    private string $aggregateId;
    private string $eventId;
    private string $occurredOn;

    public function __construct(string $aggregateId, string $eventId = null, string $occurredOn = null)
    {
        $this->aggregateId = $aggregateId;
        $this->eventId = $eventId ?: UuidValueObject::generate()->value;
        $this->occurredOn = $occurredOn ?: (new \DateTimeImmutable())->format('Y-m-d H:i:s.u T');
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn,
    ): self;

    abstract public static function eventName(): string;

    // abstract public function toPrimitives(): array;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
