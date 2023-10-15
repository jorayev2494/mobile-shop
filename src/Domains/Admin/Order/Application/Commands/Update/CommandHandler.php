<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\StatusEnum;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $order = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        if ($order === null) {
            throw new DomainException('Order not found');
        }

        $order->changeStatus(StatusEnum::from($command->status));

        $this->repository->save($order);
        $this->eventBus->publish(...$order->pullDomainEvents());
    }
}
