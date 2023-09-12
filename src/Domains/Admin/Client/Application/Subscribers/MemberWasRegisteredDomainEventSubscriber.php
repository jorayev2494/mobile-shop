<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Subscribers;

use Project\Domains\Admin\Client\Application\Commands\Create\Command;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class MemberWasRegisteredDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            MemberWasRegisteredDomainEvent::class,
        ];
    }

    public function __invoke(MemberWasRegisteredDomainEvent $event): void
    {
        $this->commandBus->dispatch(
            new Command(
                $event->uuid,
                $event->firstName,
                $event->lastName,
                $event->email,
                ''
            )
        );
    }
}
