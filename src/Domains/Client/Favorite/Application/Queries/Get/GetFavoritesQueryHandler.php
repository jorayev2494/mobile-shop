<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Queries\Get;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class GetFavoritesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly GetFavoritesService $service,
    )
    {
        
    }

    public function __invoke(GetFavoritesQuery $query): LengthAwarePaginator
    {
        return $this->service->execute($query);
    }
}
