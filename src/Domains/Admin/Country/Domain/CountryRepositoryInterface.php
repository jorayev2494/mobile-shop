<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUuid;
use Project\Shared\Application\Query\BaseQuery;

interface CountryRepositoryInterface
{
    public function paginate(BaseQuery $dataDTO, iterable $columns = ['*']): Paginator;
    public function findByUuid(CountryUuid $uuid): ?Country;
    public function save(Country $country): void;
    public function delete(Country $country): void;
}
