<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Doctrine;

use App\Repositories\Base\BaseEntityRepository;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\CountryEntity;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUUID;

class CountryRepository extends BaseEntityRepository implements CountryRepositoryInterface
{
    public function getEntity()
    {
        return CountryEntity::class;
    }

    public function findByUUID(CountryUUID $uuid): ?CountryEntity
    {
        $country = $this->entityRepository->find($uuid->value);

        return $country;
    }

    public function save(Country $country): void
    {

    }

    public function delete(CountryUUID $uuid): void
    {

    }
}
