<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure\Eloquent;

use App\Models\Client;
use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Project\Domains\Client\Favorite\Domain\Favorite;
use Project\Domains\Client\Favorite\Domain\FavoriteRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUUID;
use Project\Shared\Application\Query\BaseQuery;

final class FavoriteRepository extends BaseModelRepository implements FavoriteRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\FavoriteClient::class;
    }

    public function favorite(Favorite $favorite): void
    {
        $this->getModelClone()->newQuery()->create([
            'client_uuid' => $favorite->memberUUID->value,
            'product_uuid' => $favorite->productUUID->value,
        ]);
    }

    public function unfavorite(Favorite $favorite): void
    {
        $this->getModelClone()->newQuery()->where([
            ['client_uuid', $favorite->memberUUID->value],
            ['product_uuid', $favorite->productUUID->value],
        ])?->delete();
    }

    public function getClientFavoritesPaginate(BaseQuery $query, MemberUUID $memberUUID): CursorPaginator
    {
        /** @var Builder $query */
        $query = $this->getModelClone()->newQuery()->where(['client_uuid' => $memberUUID->value])
                                                    // ->with(['cover', 'currency'])
                                                    ;


        return $query->cursorPaginate();
    }

    public function contains(Favorite $favorite): bool
    {
        return $this->getModelClone()->newQuery()->where([
            ['client_uuid', $favorite->memberUUID->value],
            ['product_uuid', $favorite->productUUID->value],
        ])->exists();
    }
}
