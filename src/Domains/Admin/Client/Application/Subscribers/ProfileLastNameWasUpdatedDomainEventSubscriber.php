<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Subscribers;

use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientLastName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileLastNameWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileLastNameWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProfileLastNameWasUpdatedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileLastNameWasUpdatedDomainEvent $event): void
    {
        $client = $this->repository->findByUuid(ClientUuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setLastName(ClientLastName::fromValue($event->lastName));

        $this->repository->save($client);
    }
}
