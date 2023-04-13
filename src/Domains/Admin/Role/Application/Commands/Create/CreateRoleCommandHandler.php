<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Create;

use Project\Domains\Admin\Role\Domain\Role;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;
use Project\Shared\Domain\Bus\Event\EventBus;
use Project\Shared\Domain\Bus\Command\CommandHandler;

class CreateRoleCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
        private readonly EventBus $eventBus,
    )
    {
        
    }

    public function __invoke(CreateRoleCommand $command): void
    {
        $role = Role::create(
            RoleId::fromValue(),
            RoleValue::fromValue($command->value),
            $command->isActive,
        );

        $this->repository->save($role);

        $this->eventBus->dispatch(...$role->pullDomainEvents());
    }
}
