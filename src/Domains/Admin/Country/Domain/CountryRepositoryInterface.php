<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUUID;

interface CountryRepositoryInterface extends BaseModelRepositoryInterface
{
    public function findByUUID(CountryUUID $uuid): ?Country;

    public function save(Country $country): void;
    public function delete(CountryUUID $uuid): void;
}
