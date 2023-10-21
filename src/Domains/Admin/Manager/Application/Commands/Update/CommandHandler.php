<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerEmail;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerLastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $manager = $this->repository->findByUuid(ManagerUuid::fromValue($command->uuid));

        if ($manager === null) {
            throw new ModelNotFoundException();
        }

        $manager->changeEmail(ManagerEmail::fromValue($command->email));
        $manager->changeFirstName(ManagerFirstName::fromValue($command->firstName));
        $manager->changeLastName(ManagerLastName::fromValue($command->lastName));
        $manager->changeRoleId($command->roleId);

        $this->repository->save($manager);
        $this->eventBus->publish(...$manager->pullDomainEvents());
    }
}
