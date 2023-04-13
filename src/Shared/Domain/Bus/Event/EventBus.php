<?php

namespace Project\Shared\Domain\Bus\Event;

interface EventBus
{
    public function dispatch(Event ...$events): void;

    // public function publish(DomainEvent ...$events): void;

    // public function subscribe(DomainEventSubscriber $subscriber): void;

    // public function unsubscribe(DomainEventSubscriber $subscriber): void;
}
