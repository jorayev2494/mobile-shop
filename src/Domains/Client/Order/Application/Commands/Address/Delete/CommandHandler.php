<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Address\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $address = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        $address ?? throw new ModelNotFoundException();

        $address->delete();

        $this->repository->delete($address);
        $this->eventBus->publish(...$address->pullDomainEvents());
    }
}
