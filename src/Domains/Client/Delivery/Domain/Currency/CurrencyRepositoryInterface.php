<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Currency;

use Project\Domains\Client\Delivery\Domain\Currency\ValueObjects\Uuid;

interface CurrencyRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Currency;

    public function save(Currency $currency): void;

    public function delete(Currency $currency): void;
}
