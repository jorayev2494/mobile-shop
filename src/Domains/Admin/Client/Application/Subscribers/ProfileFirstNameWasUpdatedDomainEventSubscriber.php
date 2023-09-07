<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Subscribers;

use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientFirstName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileFirstNameWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileFirstNameWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProfileFirstNameWasUpdatedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileFirstNameWasUpdatedDomainEvent $event): void
    {
        $client = $this->repository->findByUuid(ClientUuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setFirstName(ClientFirstName::fromValue($event->firstName));

        $this->repository->save($client);
    }
}
