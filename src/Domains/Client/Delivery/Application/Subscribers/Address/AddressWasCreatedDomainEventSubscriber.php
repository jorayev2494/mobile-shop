<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Address;

use Project\Domains\Client\Address\Domain\Events\AddressWasCreatedDomainEvent;
use Project\Domains\Client\Delivery\Domain\Address\Address;
use Project\Domains\Client\Delivery\Domain\Address\AddressRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class AddressWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly AddressRepositoryInterface $addressRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            AddressWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(AddressWasCreatedDomainEvent $event): void
    {
        $address = Address::fromPrimitives(
            $event->uuid,
            $event->title,
            $event->fullName,
            $event->authorUuid,
            $event->firstAddress,
            $event->secondAddress,
            $event->zipCode,
            $event->countryUuid,
            $event->cityUuid,
            $event->district
        );

        $this->addressRepository->save($address);
    }
}
