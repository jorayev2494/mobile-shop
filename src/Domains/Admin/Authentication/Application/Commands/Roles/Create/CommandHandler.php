<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Roles\Create;

use Project\Domains\Admin\Authentication\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Role\Role;
use Project\Domains\Admin\Authentication\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Role\ValueObjects\Value;
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
            Value::fromValue($command->value),
            $permissions,
        );

        $this->repository->save($role);
        $this->eventBus->publish(...$role->pullDomainEvents());
    }
}
