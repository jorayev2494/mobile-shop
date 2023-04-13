<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Role\Application\Commands\Update\UpdateRoleCommand;
use Project\Domains\Admin\Role\Domain\Role;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandler;

final class UpdateRoleCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
    )
    {

    }

    public function __invoke(UpdateRoleCommand $command): void
    {
        $role = $this->repository->findOrNull($command->id);

        if ($role === null) {
            throw new ModelNotFoundException();
        }

        $role = Role::fromPrimitives(
            $command->id,
            $command->value,
            $command->isActive,
        );

        $this->repository->save($role);
    }
}
