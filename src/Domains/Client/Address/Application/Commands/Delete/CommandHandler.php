<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $address = $this->repository->findByUuid(AddressUuid::fromValue($command->uuid));

        $address ?? throw new ModelNotFoundException();

        $address->delete();

        $this->repository->delete($address);
        $this->eventBus->publish(...$address->pullDomainEvents());
    }
}
