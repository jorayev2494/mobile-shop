<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;

final class FindOrderService
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    )
    {
        
    }

    public function execute(OrderUUID $uuid): object
    {
        $order = $this->repository->find($uuid);

        if ($order === null) {
            throw new ModelNotFoundException();
        }

        return $order;
    }
}
