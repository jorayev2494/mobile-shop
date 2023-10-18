<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Currencies\Show;

use DomainException;
use Project\Domains\Admin\Product\Domain\Currency\Currency;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class QueryHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
    ) {

    }

    public function __invoke(Query $query): Currency
    {
        $currency = $this->currencyRepository->findByUuid(Uuid::fromValue($query->uuid));

        if ($currency === null) {
            throw new DomainException('Currency not found');
        }

        return $currency;
    }
}
