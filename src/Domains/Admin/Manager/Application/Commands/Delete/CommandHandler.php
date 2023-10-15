<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $manager = $this->repository->findByUuid(ManagerUuid::fromValue($command->uuid));

        if ($manager === null) {
            throw new ModelNotFoundException();
        }

        $this->repository->delete($manager);
    }
}
