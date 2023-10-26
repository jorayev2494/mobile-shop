<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Profile;

use Project\Domains\Client\Delivery\Domain\Customer\CustomerRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Phone;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfilePhoneWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfilePhoneWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
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
        $customer = $this->customerRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($customer === null) {
            return;
        }

        $customer->setPhone(Phone::fromValue($event->phone));

        $this->customerRepository->save($customer);
    }
}
