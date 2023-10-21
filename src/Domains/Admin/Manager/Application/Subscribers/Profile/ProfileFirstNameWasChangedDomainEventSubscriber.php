<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Subscribers\Profile;

use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Domains\Admin\Profile\Domain\Profile\Events\ProfileFirstNameWasChangedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class ProfileFirstNameWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProfileFirstNameWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileFirstNameWasChangedDomainEvent $event): void
    {
        $manager = $this->repository->findByUuid(ManagerUuid::fromValue($event->uuid));

        if ($manager === null) {
            return;
        }

        $manager->setFirstName(ManagerFirstName::fromValue($event->firstName));

        $this->repository->save($manager);
    }
}
