<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Profile;

use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Email;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileEmailWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileEmailWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProfileEmailWasUpdatedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileEmailWasUpdatedDomainEvent $event): void
    {
        $client = $this->clientRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setEmail(Email::fromValue($event->email));

        $this->clientRepository->save($client);
    }
}
