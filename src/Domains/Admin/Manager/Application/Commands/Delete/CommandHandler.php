<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Commands\Delete;

use Project\Domains\Admin\Manager\Domain\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerUUID;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $this->repository->delete(ManagerUUID::fromValue($command->uuid));
    }
}
