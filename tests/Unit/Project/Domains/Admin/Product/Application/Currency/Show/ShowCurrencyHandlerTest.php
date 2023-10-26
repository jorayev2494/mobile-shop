<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Currency\Show;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Queries\Currencies\Show\Query;
use Project\Domains\Admin\Product\Application\Queries\Currencies\Show\QueryHandler;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Domain\DomainException;
use Tests\Unit\Project\Domains\Admin\Product\Application\Currency\CurrencyFactory;

class ShowCurrencyHandlerTest extends TestCase
{
    public function testShowCurrency(): void
    {
        $handler = new QueryHandler(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
        );

        $currencyRepository->expects($this->once())
                            ->method('findByUuid')
                            ->with(Uuid::fromValue(CurrencyFactory::UUID))
                            ->willReturn($currency = CurrencyFactory::make());

        $handler(new Query(CurrencyFactory::UUID));
    }

    public function testNotFound(): void
    {

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Currency not found');
        $this->expectExceptionCode(404);

        $handler = new QueryHandler(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
        );

        $currencyRepository->expects($this->once())
                            ->method('findByUuid')
                            ->with(Uuid::fromValue(CurrencyFactory::UUID))
                            ->willReturn(null);

        $handler(new Query(CurrencyFactory::UUID));
    }
}
