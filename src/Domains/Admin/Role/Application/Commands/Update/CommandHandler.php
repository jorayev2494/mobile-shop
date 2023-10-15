<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Role\Domain\Permission\Permission;
use Project\Domains\Admin\Role\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
        private readonly PermissionRepositoryInterface $permissionRepository,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $role = $this->repository->findById($command->id);

        if ($role === null) {
            throw new ModelNotFoundException();
        }

        $role->changeValue(RoleValue::fromValue($command->value));

        $permissions = $this->permissionRepository->findManyByIds($command->permissions);

        $role->detachPermissions();

        foreach ($permissions as $permission) {
            $role->addPermission($permission);
        }

        $this->repository->save($role);
    }
}
