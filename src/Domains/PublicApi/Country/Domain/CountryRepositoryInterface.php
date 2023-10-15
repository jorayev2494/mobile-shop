<?php

declare(strict_types=1);

namespace Project\Domains\PublicApi\Country\Domain;

use Project\Shared\Application\Query\BaseQuery;

interface CountryRepositoryInterface
{
    public function get(BaseQuery $baseQueryDTO): array;
}
