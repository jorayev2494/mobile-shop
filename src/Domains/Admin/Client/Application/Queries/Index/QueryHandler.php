<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Queries\Index;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): Paginator
    {
        return $this->repository->paginate($query);
    }
}
