<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Client\Address\Domain\Address;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUUID;
use Project\Shared\Application\Query\BaseQuery;

interface AddressRepositoryInterface extends BaseModelRepositoryInterface
{
    public function findAddress(AddressUUID $uuid): object;
    public function getClientAddressesPaginate(string $uuid, BaseQuery $query): LengthAwarePaginator;
    public function save(Address $address): bool;
    public function delete(AddressUUID $uuid): void;
}
