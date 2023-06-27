<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Admin\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class ShowOrderQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(ShowOrderQuery $query): object
    {
        $order = $this->repository->find(OrderUUID::fromValue($query->uuid));

        // if ($order === null) {
        //     throw new ModelNotFoundException();
        // }

        $order ?? throw new ModelNotFoundException();

        return $order;
    }
}
