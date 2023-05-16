<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Queries\Get;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Client\Favorite\Domain\FavoriteRepositoryInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class GetFavoritesService
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly FavoriteRepositoryInterface $repository,
    )
    {
        
    }

    public function execute(GetFavoritesQuery $query): LengthAwarePaginator
    {
        return $this->repository->getClientFavoritesPaginate($this->authManager->client(), $query);
    }
}
