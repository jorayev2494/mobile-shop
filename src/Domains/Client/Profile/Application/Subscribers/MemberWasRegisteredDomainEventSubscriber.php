<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Application\Subscribers;

use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Client\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Client\Profile\Application\Commands\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class MemberWasRegisteredDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly CommandBusInterface $commandBus,
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
        $this->commandBus->dispatch(
            new Command(
                $event->uuid,
                $event->firstName,
                $event->lastName,
                $event->email
            )
        );
    }
}
