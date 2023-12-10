<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Address;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\AuthorUuid;
use Project\Shared\Application\Query\BaseQuery;

interface AddressRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Address;

    public function getByAuthorUuid(AuthorUuid $uuid, BaseQuery $query): array;

    public function paginateByAuthorUuid(AuthorUuid $uuid, BaseQuery $query): Paginator;

    public function save(Address $address): void;

    public function delete(Address $address): void;
}
