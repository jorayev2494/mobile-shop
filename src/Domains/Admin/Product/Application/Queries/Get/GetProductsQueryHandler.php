<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Get;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class GetProductsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(GetProductsQuery $query): LengthAwarePaginator
    {
        return $this->repository->getPaginate($query);
    }
}
