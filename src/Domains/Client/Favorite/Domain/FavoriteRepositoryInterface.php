<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain;

use App\Models\Client;
use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Shared\Application\Query\BaseQuery;

interface FavoriteRepositoryInterface extends BaseModelRepositoryInterface
{
    public function getClientFavoritesPaginate(Client $client, BaseQuery $queryData): LengthAwarePaginator;
}
