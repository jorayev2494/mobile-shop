<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Card\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CardRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $card = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        if ($card === null) {
            throw new DomainException('Card not found');
        }

        $card->delete();

        $this->repository->delete($card);
        $this->eventBus->publish(...$card->pullDomainEvents());
    }
}
