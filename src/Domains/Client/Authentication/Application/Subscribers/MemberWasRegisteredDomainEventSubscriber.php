<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Subscribers;

use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\FlasherInterface;

class MemberWasRegisteredDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly FlasherInterface $flasher,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            MemberWasRegisteredDomainEvent::class,
        ];
    }

    public function __invoke(MemberWasRegisteredDomainEvent $event): void
    {
        $this->flasher->publish('alerts', ['message' => 'Client was registered!']);
    }
}
