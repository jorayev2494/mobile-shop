<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Commands\Create;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerEmail;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerLastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $manager = Manager::create(
            ManagerUuid::fromValue($command->uuid),
            ManagerFirstName::fromValue($command->first_name),
            ManagerLastName::fromValue($command->last_name),
            ManagerEmail::fromValue($command->email),
        );

        $manager->setRoleId($command->roleId);

        $this->repository->save($manager);
    }
}
