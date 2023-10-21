<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Roles\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Role\RoleRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Role\ValueObjects\Id;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $role = $this->repository->findById($command->id);

        if ($role === null) {
            throw new ModelNotFoundException();
        }

        $this->repository->delete($role);
    }
}
