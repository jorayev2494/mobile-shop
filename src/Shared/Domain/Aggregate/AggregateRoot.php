<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Aggregate;

use Illuminate\Contracts\Support\Arrayable;
use Project\Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot implements Arrayable
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): iterable
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
