<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Profile;

use Project\Domains\Client\Order\Domain\Client\Client;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProfileWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileWasCreatedDomainEvent $event): void
    {
        $client = Client::fromPrimitives(
            $event->uuid,
            $event->firstName,
            $event->lastName,
            $event->email,
            $event->phone,
        );

        $this->clientRepository->save($client);
    }
}
