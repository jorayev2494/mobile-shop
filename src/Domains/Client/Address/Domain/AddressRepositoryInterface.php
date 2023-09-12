<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Domain;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Address\Domain\Address;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;
use Project\Shared\Application\Query\BaseQuery;

interface AddressRepositoryInterface
{
    public function findByUuid(AddressUuid $uuid): ?Address;
    public function getAuthorUuidPaginate(string $uuid, BaseQuery $query): Paginator;
    public function save(Address $address): void;
    public function delete(Address $address): void;
}
