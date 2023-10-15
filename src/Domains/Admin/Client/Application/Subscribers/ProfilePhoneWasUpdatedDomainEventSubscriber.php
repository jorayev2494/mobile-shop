<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Subscribers;

use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientPhone;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfilePhoneWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfilePhoneWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository,
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
        $client = $this->repository->findByUuid(ClientUuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setPhone(ClientPhone::fromValue($event->phone));

        $this->repository->save($client);
    }
}
