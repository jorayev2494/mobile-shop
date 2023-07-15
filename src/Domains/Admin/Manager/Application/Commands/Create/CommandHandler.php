<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Commands\Create;

use Project\Domains\Admin\Manager\Domain\Manager;
use Project\Domains\Admin\Manager\Domain\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerEmail;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerLastName;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerPassword;
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
        $generatedPassword = '12345Secret_';

        $manager = Manager::create(
            ManagerUUID::fromValue($command->uuid),
            ManagerFirstName::fromValue($command->first_name),
            ManagerLastName::fromValue($command->last_name),
            ManagerEmail::fromValue($command->email),
        );

        $manager->setPassword(ManagerPassword::fromValue($generatedPassword));
        $manager->setRoleId($command->roleId);

        $this->repository->save($manager);
    }
}
