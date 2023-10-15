<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus;

use Project\Shared\Infrastructure\Bus\Contracts\LocatorInterface;

class DomainEventLocator implements LocatorInterface
{
    public function __construct(
        private readonly DomainEventSubscriberLocator $domainEventSubscriberLocator
    ) {

    }

    /**
     * @return array
     */
    public function all(): array
    {
        $result = [];

        foreach ($this->domainEventSubscriberLocator->all() as $sub) {
            $handler = $sub::class;
            $result[$handler] = $this->makeSubscribersWithRoutingKey($sub->subscribedTo());
        }

        return $result;
    }

    private function makeSubscribersWithRoutingKey(array $subscribers): array
    {
        $result = [];

        foreach ($subscribers as $key => $subscriber) {
            $routingKey = $subscriber::eventName();
            $result[$routingKey] = $subscriber;
        }

        return $result;
    }
}
