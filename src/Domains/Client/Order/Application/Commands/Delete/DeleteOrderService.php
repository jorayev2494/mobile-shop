<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;

final class DeleteOrderService
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    ) {

    }

    public function execute(OrderUUID $uuid): void
    {
        $order = $this->repository->findOrNull($uuid->value);

        if ($order === null) {
            throw new ModelNotFoundException();
        }

        $this->repository->delete($order);
    }
}
