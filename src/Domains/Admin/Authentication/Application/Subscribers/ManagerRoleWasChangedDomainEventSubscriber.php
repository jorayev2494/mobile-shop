<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Subscribers;

use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerRoleWasChangedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class ManagerRoleWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly RoleRepositoryInterface $roleRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ManagerRoleWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerRoleWasChangedDomainEvent $event): void
    {
        $member = $this->repository->findByUuid($event->uuid);
        $role = $this->roleRepository->findById($event->roleId);

        if ($member === null || $role === null) {
            return;
        }

        $member->setRole($role);

        $this->repository->save($member);
    }
}
