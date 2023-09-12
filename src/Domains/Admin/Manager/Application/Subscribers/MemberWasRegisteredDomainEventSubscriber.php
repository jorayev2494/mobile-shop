<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Subscribers;

use Project\Domains\Admin\Authentication\Domain\Member\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class MemberWasRegisteredDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
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
        $profile = Manager::fromPrimitives(
            $event->uuid,
            '',
            '',
            $event->email,
        );

        $this->repository->save($profile);
    }
}
