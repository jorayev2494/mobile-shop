<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Domain\Currency;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\CurrencyUuid;
use Project\Shared\Application\Query\BaseQuery;

interface CurrencyRepositoryInterface
{
    public function get(): array;
    public function paginate(BaseQuery $dataDTO): Paginator;

    public function findByUuid(CurrencyUuid $uuid): ?Currency;

    public function save(Currency $currency): void;
}
