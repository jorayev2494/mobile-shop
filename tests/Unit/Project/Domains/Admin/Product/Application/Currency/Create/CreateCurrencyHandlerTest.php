<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Currency\Create;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Create\CommandHandler;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Create\Command;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Tests\Unit\Project\Domains\Admin\Product\Application\Currency\CurrencyFactory;

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
