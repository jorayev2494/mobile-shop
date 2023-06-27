<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Queries\Get;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Order\Domain\OrderRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class GetOrdersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(GetOrdersQuery $query): LengthAwarePaginator
    {
        return $this->repository->paginateByStatus($query);
    }
}
