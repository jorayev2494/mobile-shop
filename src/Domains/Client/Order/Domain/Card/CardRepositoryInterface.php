<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Card;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ClientUuid;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;

interface CardRepositoryInterface
{
    public function getByAuthorUuid(ClientUuid $uuid, BaseQuery $queryData): array;

    public function paginateByAuthorUuid(ClientUuid $uuid, BaseQuery $queryData): Paginator;

    public function findByUuid(Uuid $uuid): ?Card;

    public function save(Card $card): void;

    public function delete(Card $card): void;
}
