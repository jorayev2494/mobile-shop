<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;
use Project\Shared\Application\Query\BaseQuery;

interface FavoriteRepositoryInterface
{
    public function favorite(Favorite $favorite): void;

    public function unfavorite(Favorite $favorite): void;

    public function getClientFavoritesPaginate(BaseQuery $query, MemberUuid $memberUuid): CursorPaginator;

    public function contains(Favorite $favorite): bool;
}
