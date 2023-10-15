<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Card\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly CardRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $card = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        if ($card === null) {
            throw new ModelNotFoundException();
        }

        $card->delete();

        $this->repository->delete($card);
        $this->eventBus->publish(...$card->pullDomainEvents());
    }
}
