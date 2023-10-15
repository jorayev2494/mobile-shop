<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $client = $this->repository->findByUuid(ClientUuid::fromValue($command->uuid));

        $client ?? throw new ModelNotFoundException();

        $this->repository->delete($client);
    }
}
