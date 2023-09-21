<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Application\Queries\Get;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class GetProductsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(GetProductsQuery $query): Paginator
    {
        return $this->repository->paginate($query);
    }
}
