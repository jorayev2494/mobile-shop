<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Currencies\Index;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): Paginator
    {
        return $this->repository->paginate($query);
    }
}
