<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Currency\Delete;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Delete\Command;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Delete\CommandHandler;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;
use Tests\Unit\Project\Domains\Admin\Product\Application\Currency\CurrencyFactory;

/**
 * @group currency
 * @group currency-application
 */
class DeleteCurrencyHandlerTest extends TestCase
{
    public function testDeleteCurrency(): void
    {
        $handler = new CommandHandler(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $currencyRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(Uuid::fromValue(CurrencyFactory::UUID))
                        ->willReturn($currency = CurrencyFactory::make());

        $currencyRepository->expects($this->once())
                        ->method('delete');

        $eventBus->expects($this->once())
                    ->method('publish');

        $handler(new Command(CurrencyFactory::UUID));
    }

    public function testNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Currency not found');
        $this->expectExceptionCode(404);

        $handler = new CommandHandler(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $currencyRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(Uuid::fromValue(CurrencyFactory::UUID))
                        ->willReturn(null);

        $currencyRepository->expects($this->never())
                        ->method('delete');

        $eventBus->expects($this->never())
                    ->method('publish');

        $handler(new Command(CurrencyFactory::UUID));
    }
}
