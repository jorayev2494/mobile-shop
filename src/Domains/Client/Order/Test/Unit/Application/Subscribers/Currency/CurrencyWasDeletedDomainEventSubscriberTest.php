<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Currency;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Currency\Events\CurrencyValueWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Currency\Events\CurrencyWasDeletedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Currency\CurrencyValueWasChangedDomainEventSubscriber;
use Project\Domains\Client\Order\Application\Subscribers\Currency\CurrencyWasDeletedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Client\Order\Test\Unit\Application\CurrencyFactory;

/**
 * @group order-subscriber
 * @group order-currency-subscriber
 */
class CurrencyWasDeletedDomainEventSubscriberTest extends TestCase
{
    public function testSubscribedTo(): void
    {
        $this->assertContainsEquals(
            CurrencyWasDeletedDomainEvent::class,
            CurrencyWasDeletedDomainEventSubscriber::subscribedTo()
        );
    }

    public function testEventHandler(): void
    {
        $handler = new CurrencyWasDeletedDomainEventSubscriber(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
        );

        $currencyRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(CurrencyFactory::UUID))
            ->will($this->returnValue($currency = CurrencyFactory::make()));

        $currencyRepository->expects($this->once())
            ->method('delete')
            ->with($currency);

        $handler(
            new CurrencyWasDeletedDomainEvent(
                CurrencyFactory::UUID,
            )
        );
    }

    public function testCurrencyNotFound(): void
    {
        $handler = new CurrencyValueWasChangedDomainEventSubscriber(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
        );

        $currencyRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(CurrencyFactory::UUID))
            ->willReturn(null);

        $currencyRepository->expects($this->never())
            ->method('save');

        $handler(
            new CurrencyValueWasChangedDomainEvent(
                CurrencyFactory::UUID,
                'USD',
            )
        );
    }
}
