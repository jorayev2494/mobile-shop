<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Roles\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Permission\PermissionRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Role\ValueObjects\Value;
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

        $role->changeValue(Value::fromValue($command->value));

        $permissions = $this->permissionRepository->findManyByIds($command->permissions);

        $role->detachPermissions();

        foreach ($permissions as $permission) {
            $role->addPermission($permission);
        }

        $this->repository->save($role);
    }
}
