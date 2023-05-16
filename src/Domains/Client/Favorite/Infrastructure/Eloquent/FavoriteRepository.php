<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure\Eloquent;

use App\Models\Client;
use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Project\Domains\Client\Favorite\Domain\FavoriteRepositoryInterface;
use Project\Shared\Application\Query\BaseQuery;

final class FavoriteRepository extends BaseModelRepository implements FavoriteRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\FavoriteClient::class;
    }

    public function getClientFavoritesPaginate(Client $client, BaseQuery $queryData): LengthAwarePaginator
    {
        /** @var Builder $query */
        $query = $client->favorites()->getQuery();

        $this->search($queryData, $query)
            ->sort($queryData, $query)
            ->filters($queryData, $query);

        return $query->paginate($queryData->per_page);
    }
}
