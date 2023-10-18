<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Currency;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;

interface CurrencyRepositoryInterface
{
    public function get(): array;

    public function paginate(BaseQuery $dataDTO): Paginator;

    public function findByUuid(Uuid $uuid): ?Currency;

    public function save(Currency $currency): void;

    public function delete(Currency $currency): void;
}
