<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Currency;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Currency\Events\CurrencyValueWasChangedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Currency\CurrencyValueWasChangedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Currency\Currency;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Value;
use Project\Domains\Client\Order\Test\Unit\Application\CurrencyFactory;

/**
 * @group order-subscriber
 * @group order-currency-subscriber
 */
class CurrencyValueWasChangedDomainEventSubscriberTest extends TestCase
{
    public function testSubscribedTo(): void
    {
        $this->assertContainsEquals(
            CurrencyValueWasChangedDomainEvent::class,
            CurrencyValueWasChangedDomainEventSubscriber::subscribedTo()
        );
    }

    public function testEventHandler(): void
    {
        $handler = new CurrencyValueWasChangedDomainEventSubscriber(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
        );

        $currency = $this->getMockBuilder(Currency::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'setValue',
            ])
            ->getMock();

        $currency->expects($this->once())
            ->method('setValue')
            ->with(Value::fromValue('USD'));

        $currencyRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(CurrencyFactory::UUID))
            ->will($this->returnValue($currency));

        $currencyRepository->expects($this->once())
            ->method('save')
            ->with($currency);

        $handler(
            new CurrencyValueWasChangedDomainEvent(
                CurrencyFactory::UUID,
                'USD',
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
