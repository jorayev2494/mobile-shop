<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Subscribers;

use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileEmailWasUpdatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProfileEmailWasUpdatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
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
        $member = $this->repository->findByUuid($event->uuid);

        if ($member === null) {
            return;
        }

        $member->setEmail($event->email);

        $this->repository->save($member);
    }
}
