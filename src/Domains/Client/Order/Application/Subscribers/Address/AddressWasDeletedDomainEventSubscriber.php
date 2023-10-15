<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Address;

use Project\Domains\Client\Address\Domain\Events\AddressWasDeletedDomainEvent;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class AddressWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly AddressRepositoryInterface $addressRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            AddressWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(AddressWasDeletedDomainEvent $event): void
    {
        $address = $this->addressRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($address === null) {
            return;
        }

        $this->addressRepository->delete($address);
    }
}
