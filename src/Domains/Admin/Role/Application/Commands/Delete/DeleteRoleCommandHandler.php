<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Delete;

use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;
use Project\Shared\Domain\Bus\Command\CommandHandler;

final class DeleteRoleCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
    )
    {

    }

    public function __invoke(DeleteRoleCommand $command): void
    {
        $this->repository->delete(RoleId::fromValue($command->id));
    }
}
