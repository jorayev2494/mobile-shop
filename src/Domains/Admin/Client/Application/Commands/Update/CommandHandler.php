<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientEmail;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientFirstName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientLastName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientPhone;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $client = $this->repository->findByUuid(ClientUuid::fromValue($command->uuid));

        $client ?? throw new ModelNotFoundException;

        $client->setFirstName(ClientFirstName::fromValue($command->firstName));
        $client->setLastName(ClientLastName::fromValue($command->lastName));
        $client->setEmail(ClientEmail::fromValue($command->email));
        $client->setPhone(ClientPhone::fromValue($command->phone));

        $this->repository->save($client);
    }
}
