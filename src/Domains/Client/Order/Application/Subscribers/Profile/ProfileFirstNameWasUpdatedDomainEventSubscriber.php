<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Profile;

use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\FirstName;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileFirstNameWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileFirstNameWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository
    ) {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProfileFirstNameWasUpdatedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileFirstNameWasUpdatedDomainEvent $event): void
    {
        $client = $this->clientRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setFirstName(FirstName::fromValue($event->firstName));

        $this->clientRepository->save($client);
    }
}
