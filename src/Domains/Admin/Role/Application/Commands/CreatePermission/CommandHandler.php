<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\CreatePermission;

use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\PermissionSubject;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\PermissionAction;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly PermissionRepositoryInterface $permissionRepository,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $permission = Permission::create(
            PermissionSubject::fromValue($command->subject),
            PermissionAction::fromValue($command->action)
        );

        $this->permissionRepository->save($permission);
    }
}
