<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Roles\CreatePermission;

use Project\Domains\Admin\Authentication\Domain\Permission\Permission;
use Project\Domains\Admin\Authentication\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects\Subject;
use Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects\Action;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly PermissionRepositoryInterface $permissionRepository,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $permission = Permission::create(
            Subject::fromValue($command->subject),
            Action::fromValue($command->action)
        );

        $this->permissionRepository->save($permission);
    }
}
