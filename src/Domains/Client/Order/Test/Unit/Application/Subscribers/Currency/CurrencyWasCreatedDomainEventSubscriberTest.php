<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Currency;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Currency\Events\CurrencyWasCreatedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Currency\CurrencyWasCreatedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Test\Unit\Application\CurrencyFactory;

/**
 * @group order-subscriber
 * @group order-currency-subscriber
 */
class CurrencyWasCreatedDomainEventSubscriberTest extends TestCase
{
    public function testSubscribedTo(): void
    {
        $this->assertContainsEquals(
            CurrencyWasCreatedDomainEvent::class,
            CurrencyWasCreatedDomainEventSubscriber::subscribedTo()
        );
    }

    public function testEventHandler(): void
    {
        $handler = new CurrencyWasCreatedDomainEventSubscriber(
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
        );

        $currencyRepository->expects($this->once())
            ->method('save')
            ->with(CurrencyFactory::make());

        $handler(
            new CurrencyWasCreatedDomainEvent(
                CurrencyFactory::UUID,
                CurrencyFactory::CURRENCY,
                CurrencyFactory::IS_ACTIVE,
            )
        );
    }
}
