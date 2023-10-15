<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Queries\Get;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Order\Domain\Order\OrderRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\StatusEnum;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): Paginator
    {
        $status = $query->status ? StatusEnum::from($query->status) : $query->status;

        return $this->repository->paginateByStatus($query, $status);
    }
}
