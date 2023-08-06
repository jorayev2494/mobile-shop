<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Client\Card\Domain\ValueObjects\CardClientUUID;
use Project\Domains\Client\Card\Domain\ValueObjects\CardUUID;
use Project\Shared\Application\Query\BaseQuery;

interface CardRepositoryInterface extends BaseModelRepositoryInterface
{
    public function getClientCardsPaginate(CardClientUUID $uuid, BaseQuery $queryData): LengthAwarePaginator;
    public function find(CardUUID $uuid): ?Card;
    public function save(Card $card): bool;
    public function delete(CardUUID $uuid): void;
}
