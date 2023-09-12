<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Get;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): Paginator
    {
        return $this->repository->paginate($query);
    }
}
