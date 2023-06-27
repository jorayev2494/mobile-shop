<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Admin\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class UpdateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(UpdateOrderCommand $command): void
    {
        dd($command);
        $order = $this->repository->find(OrderUUID::fromValue($command->uuid));

        if ($order === null) {
            throw new ModelNotFoundException;
        }

        $this->repository->save($order);
    }
}
