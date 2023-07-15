<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Manager\Domain\Manager;
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
        $fManager = $this->repository->findByUUID(ManagerUUID::fromValue($command->uuid));

        if ($fManager === null) {
            throw new ModelNotFoundException();
        }

        $manager = Manager::fromPrimitives($command->uuid, $command->firstName, $command->lastName, $command->email);
        $manager->setRoleId($command->roleId);

        $this->repository->save($manager);
    }
}
