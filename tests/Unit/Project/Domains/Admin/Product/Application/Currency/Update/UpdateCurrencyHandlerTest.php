<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Currency\Update;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Update\Command;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Update\CommandHandler;
use Project\Domains\Admin\Product\Domain\Currency\Currency;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Tests\Unit\Project\Domains\Admin\Product\Application\Currency\CurrencyFactory;

class UpdateCurrencyHandlerTest extends TestCase
{
    public function testUpdateCurrency(): void
    {
        $handler = new CommandHandler(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $currencyStub = $this->createStub(Currency::class);

        $currencyStub->expects($this->once())->method('changeValue');
        $currencyStub->expects($this->once())->method('changeIsActive');
        // $currencyStub->expects($this->once())->method('record');
        $currencyStub->expects($this->once())->method('pullDomainEvents');

        $currencyRepository->expects($this->once())
                            ->method('findByUuid')
                            ->with(Uuid::fromValue(CurrencyFactory::UUID))
                            ->willReturn($currencyStub);

        $currencyRepository->expects($this->once())
                            ->method('save');

        $eventBus->expects($this->once())
                    ->method('publish');
                
        $handler(
            new Command(
                CurrencyFactory::UUID,
                'UAH',
                false
            )
        );
        
    }
}
