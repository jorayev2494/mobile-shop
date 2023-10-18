<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Categories\Get;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {

    }

    public function __invoke(Query $query): Paginator
    {
        return $this->repository->paginate($query);
    }
}
