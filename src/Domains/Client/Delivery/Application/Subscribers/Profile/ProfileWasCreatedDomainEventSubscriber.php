<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Profile;

use Project\Domains\Client\Delivery\Domain\Customer\Customer;
use Project\Domains\Client\Delivery\Domain\Customer\CustomerRepositoryInterface;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $clientRepository,
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
        $client = Customer::fromPrimitives(
            $event->uuid,
            $event->firstName,
            $event->lastName,
            $event->email,
            $event->phone,
        );

        $this->clientRepository->save($client);
    }
}
