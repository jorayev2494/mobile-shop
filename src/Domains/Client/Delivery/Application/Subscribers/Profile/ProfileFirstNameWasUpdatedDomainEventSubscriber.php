<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Profile;

use Project\Domains\Client\Delivery\Domain\Customer\CustomerRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\FirstName;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileFirstNameWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileFirstNameWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
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
        $customer = $this->customerRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($customer === null) {
            return;
        }

        $customer->setFirstName(FirstName::fromValue($event->firstName));

        $this->customerRepository->save($customer);
    }
}
