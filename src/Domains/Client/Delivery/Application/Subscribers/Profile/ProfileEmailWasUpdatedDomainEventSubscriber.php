<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Profile;

use Project\Domains\Client\Delivery\Domain\Customer\CustomerRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Email;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Uuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileEmailWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileEmailWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
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
        $client = $this->customerRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setEmail(Email::fromValue($event->email));

        $this->customerRepository->save($client);
    }
}
