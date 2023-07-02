<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Create;

use Project\Domains\Admin\Role\Domain\Role;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

class CreateRoleCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(CreateRoleCommand $command): void
    {
        $role = Role::create(
            RoleId::fromValue(),
            RoleValue::fromValue($command->value),
            $command->permissions,
            $command->isActive,
        );

        $this->repository->save($role);

        $this->eventBus->publish(...$role->pullDomainEvents());
    }
}
