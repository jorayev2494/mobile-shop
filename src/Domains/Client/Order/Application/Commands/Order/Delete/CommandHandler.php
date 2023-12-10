<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Order\Delete;

use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\DomainException;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $order = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        if ($order === null) {
            throw new DomainException('Order not found');
        }

        $this->repository->delete($order);
    }
}
