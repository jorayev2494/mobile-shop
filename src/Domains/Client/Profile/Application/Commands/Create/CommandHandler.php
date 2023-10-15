<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Application\Commands\Create;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Domains\Client\Profile\Domain\Profile\Profile;
use Project\Domains\Client\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Client\Profile\Domain\Profile\ValueObjects\ProfileEmail;
use Project\Domains\Client\Profile\Domain\Profile\ValueObjects\ProfileFirstName;
use Project\Domains\Client\Profile\Domain\Profile\ValueObjects\ProfileLastName;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $profile = Profile::create(
            $command->uuid,
            ProfileFirstName::fromValue($command->firstName),
            ProfileLastName::fromValue($command->lastName),
            ProfileEmail::fromValue($command->email),
        );

        $this->repository->save($profile);
        $this->eventBus->publish(...$profile->pullDomainEvents());
    }
}
