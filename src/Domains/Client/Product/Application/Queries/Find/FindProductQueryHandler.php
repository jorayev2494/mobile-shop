<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Application\Queries\Find;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandler;

final class FindProductQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(FindProductQuery $query): object
    {
        $product = $this->repository->findOrNull($query->uuid);

        if ($product === null) {
            throw new ModelNotFoundException();
        }

        return $product;
    }
}
