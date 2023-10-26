<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Profile;

use Project\Domains\Client\Delivery\Domain\Customer\CustomerRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\LastName;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileFirstNameWasUpdatedDomainEvent;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileLastNameWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileLastNameWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
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
        $customer = $this->customerRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($customer === null) {
            return;
        }

        $customer->setLastName(LastName::fromValue($event->lastName));

        $this->customerRepository->save($customer);
    }
}
