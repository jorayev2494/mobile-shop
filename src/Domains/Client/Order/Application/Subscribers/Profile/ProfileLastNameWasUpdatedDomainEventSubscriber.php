<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Profile;

use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\LastName;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileFirstNameWasUpdatedDomainEvent;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileLastNameWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileLastNameWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository
    ) {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProfileLastNameWasUpdatedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileLastNameWasUpdatedDomainEvent $event): void
    {
        $client = $this->clientRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setLastName(LastName::fromValue($event->lastName));

        $this->clientRepository->save($client);
    }
}
