<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\ValueObjects\CardUUID;
use Project\Shared\Domain\Bus\Command\CommandHandler;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class DeleteCardCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly CardRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(DeleteCardCommand $command): void
    {
        $uuid = CardUUID::fromValue($command->uuid);

        $foundCard = $this->repository->find($uuid);

        if ($foundCard === null) {
            throw new ModelNotFoundException();
        }

        $this->repository->delete($uuid);
    }
}
