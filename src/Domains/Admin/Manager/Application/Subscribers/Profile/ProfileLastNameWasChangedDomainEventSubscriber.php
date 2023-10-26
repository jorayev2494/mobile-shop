<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Subscribers\Profile;

use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerLastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Domains\Admin\Profile\Domain\Profile\Events\ProfileLastNameWasChangedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class ProfileLastNameWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProfileLastNameWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileLastNameWasChangedDomainEvent $event): void
    {
        $manager = $this->repository->findByUuid(ManagerUuid::fromValue($event->uuid));

        if ($manager === null) {
            return;
        }

        $manager->setLastName(ManagerLastName::fromValue($event->lastName));

        $this->repository->save($manager);
    }
}
