<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Queries\Index;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): Paginator
    {
        return $this->repository->paginate($query);
    }
}
