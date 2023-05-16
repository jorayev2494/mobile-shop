<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Event;

abstract class DomainEvent implements Event
{
    public const TYPE = 'event';

    protected readonly EventUUID $eventUUID;
    
    protected readonly string $firedAt;

    public function __construct()
    {
        $this->eventUUID = new EventUUID();
        $this->firedAt = date('Y-m-d H:i:s');
    }

    public function getType(): string
    {
        return static::TYPE;
    }

    public function jsonSerialize() : array
    {
        return [
            'type'      => $this->getType(),
            'event_id'  => (string) $this->eventUUID,
            'fired_at'  => $this->firedAt,
        ];
    }
}
