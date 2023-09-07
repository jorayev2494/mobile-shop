<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Application\Subscribers;

use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Client\Profile\Domain\Profile\Profile;
use Project\Domains\Client\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

final class MemberWasRegisteredDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            MemberWasRegisteredDomainEvent::class,
        ];
    }

    public function __invoke(MemberWasRegisteredDomainEvent $event): void
    {
        $profile = Profile::fromPrimitives(
            $event->uuid,
            $event->firstName,
            $event->lastName,
            $event->email,
        );

        $this->repository->save($profile);
    }
}
