<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Commands\Create;

use Project\Domains\Admin\Client\Domain\Client\Client;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientEmail;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientFirstName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientLastName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientPhone;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $client = Client::create(
            ClientUuid::fromValue($command->uuid),
            ClientFirstName::fromValue($command->firstName),
            ClientLastName::fromValue($command->lastName),
            ClientEmail::fromValue($command->email),
            ClientPhone::fromValue($command->phone)
        );

        $this->repository->save($client);
    }
}
