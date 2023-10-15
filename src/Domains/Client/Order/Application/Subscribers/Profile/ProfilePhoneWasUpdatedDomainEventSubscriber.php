<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Profile;

use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Phone;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileEmailWasUpdatedDomainEvent;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfilePhoneWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfilePhoneWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository
    ) {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProfilePhoneWasUpdatedDomainEvent::class,
        ];
    }

    public function __invoke(ProfilePhoneWasUpdatedDomainEvent $event): void
    {
        $client = $this->clientRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setPhone(Phone::fromValue($event->phone));

        $this->clientRepository->save($client);
    }
}
