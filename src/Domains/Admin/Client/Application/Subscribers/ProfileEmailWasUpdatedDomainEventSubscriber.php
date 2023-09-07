<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Subscribers;

use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientEmail;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileEmailWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileEmailWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProfileEmailWasUpdatedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileEmailWasUpdatedDomainEvent $event): void
    {
        $client = $this->repository->findByUuid(ClientUuid::fromValue($event->uuid));

        if ($client === null) {
            return;
        }

        $client->setEmail(ClientEmail::fromValue($event->email));

        $this->repository->save($client);
    }
}
