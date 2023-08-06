<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Get;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class GetOrdersQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly GetOrdersService $service
    )
    {
        
    }

    public function __invoke(GetOrdersQuery $query): LengthAwarePaginator
    {
        return $this->service->execute($query);
    }
}
