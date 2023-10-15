<?php

declare(strict_types=1);

namespace Project\Domains\PublicApi\Currency\Domain\Currency;

use Project\Shared\Application\Query\BaseQuery;

interface CurrencyRepositoryInterface
{
    public function get(BaseQuery $baseQueryDTO): array;
}
