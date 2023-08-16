<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUUID;
use Project\Shared\Application\Query\BaseQuery;

interface FavoriteRepositoryInterface extends BaseModelRepositoryInterface
{
    public function favorite(Favorite $favorite): void;
    
    public function unfavorite(Favorite $favorite): void;

    public function getClientFavoritesPaginate(BaseQuery $query, MemberUUID $memberUUID): CursorPaginator;

    public function contains(Favorite $favorite): bool;
}
