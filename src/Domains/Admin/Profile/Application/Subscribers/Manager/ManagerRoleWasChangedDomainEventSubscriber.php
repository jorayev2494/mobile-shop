<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Subscribers\Manager;

use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerRoleWasChangedDomainEvent;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class ManagerRoleWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ManagerRoleWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerRoleWasChangedDomainEvent $event): void
    {
        $profile = $this->repository->findByUuid($event->uuid);

        if ($profile === null) {
            return;
        }

        $profile->setRoleId($event->roleId);

        $this->repository->save($profile);
    }
}
