<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Test\Unit\Application\Currency\Create;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Create\Command;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Create\CommandHandler;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Test\Unit\Application\Currency\CurrencyFactory;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

/**
 * @group currency
 * @group currency-application
 */
class CreateCurrencyHandlerTest extends TestCase
{
    public function testCreateCurrency(): void
    {
        $handler = new CommandHandler(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $currencyRepository->expects($this->once())
                        ->method('save');

        $eventBus->expects($this->once())
                ->method('publish');

        $handler(
            new Command(
                CurrencyFactory::UUID,
                CurrencyFactory::CURRENCY,
                CurrencyFactory::IS_ACTIVE,
            )
        );
    }
}
