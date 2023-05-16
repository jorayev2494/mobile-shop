<?php

declare(strict_types=1);

namespace Project\Domains\CLient\Address\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\Address;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUUID;
use Project\Shared\Application\Query\BaseQuery;

final class AddressRepository extends BaseModelRepository implements AddressRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Address::class;
    }

    public function findAddress(AddressUUID $uuid): object
    {
        $query = $this->getModelClone()->query();

        $query->where('uuid', '=', $uuid->value);
        $query->with([
            'client',
            'country',
            'city',
        ]);

        return $query->firstOrFail();
    }

    public function getClientAddressesPaginate(string $uuid, BaseQuery $queryData): LengthAwarePaginator
    {
        $query = $this->getModelClone()->newQuery()->where('client_uuid', $uuid);

        $this->search($queryData, $query)
            ->sort($queryData, $query)
            ->filters($queryData, $query);

        $query->with([
            'country',
            'city',
        ]);

        return $query->paginate($queryData->per_page);
    }

    public function save(Address $address): bool
    {
        return (bool) $this->getModelClone()->newQuery()->updateOrCreate(
            ['uuid' => $address->uuid->value],
            $address->toArray()
        );
    }

    public function delete(AddressUUID $uuid): void
    {
        $address = $this->findOrFail($uuid->value);
        $address->delete();
    }
}
