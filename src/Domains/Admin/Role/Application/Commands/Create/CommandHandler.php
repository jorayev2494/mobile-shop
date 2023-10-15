<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Create;

use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Role;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
        private readonly PermissionRepositoryInterface $permissionRepository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $permissions = $this->permissionRepository->findManyByIds($command->permissions);

        $role = Role::create(
            RoleValue::fromValue($command->value),
            $permissions,
        );

        $this->repository->save($role);
        $this->eventBus->publish(...$role->pullDomainEvents());
    }
}
