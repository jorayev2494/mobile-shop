<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Domain\Currency;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Domain\Currency\Currency;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Value;
use Project\Domains\Client\Order\Test\Unit\Application\CurrencyFactory;
use Project\Shared\Domain\Aggregate\AggregateRoot;

/**
 * @group order-domain
 * @group order-currency-domain
 */
class CurrencyTest extends TestCase
{
    private Currency $currency;

    protected function setUp(): void
    {
        $this->currency = CurrencyFactory::make();
    }

    public function testFromPrimitives(): void
    {
        $currency = Currency::fromPrimitives(
            CurrencyFactory::UUID,
            CurrencyFactory::CURRENCY,
            CurrencyFactory::IS_ACTIVE,
        );

        $this->assertNotNull($currency);
        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertNotInstanceOf(AggregateRoot::class, $currency);

        $this->assertInstanceOf(Uuid::class, $currency->getUuid());
        $this->assertSame(CurrencyFactory::UUID, $currency->getUuid()->value);

        $this->assertInstanceOf(Value::class, $currency->getValue());
        $this->assertSame(CurrencyFactory::CURRENCY, $currency->getValue()->value);

        $this->assertIsBool($currency->getIsActive());
        $this->assertSame(CurrencyFactory::IS_ACTIVE, $currency->getIsActive());
    }

    public function testCurrencySetValue(): void
    {
        $this->assertInstanceOf(Value::class, $this->currency->getValue());
        $this->assertSame(CurrencyFactory::CURRENCY, $this->currency->getValue()->value);

        $this->currency->setValue(Value::fromValue('TMT'));

        $this->assertInstanceOf(Value::class, $this->currency->getValue());
        $this->assertNotSame(CurrencyFactory::CURRENCY, $this->currency->getValue()->value);
        $this->assertSame('TMT', $this->currency->getValue()->value);
    }

    public function testCurrencySetIsActive(): void
    {
        $this->assertIsBool($this->currency->getIsActive());
        $this->assertSame(CurrencyFactory::IS_ACTIVE, $this->currency->getIsActive());

        $this->currency->setIsActive(false);

        $this->assertIsBool($this->currency->getIsActive());
        $this->assertNotSame(CurrencyFactory::IS_ACTIVE, $this->currency->getIsActive());
        $this->assertSame(false, $this->currency->getIsActive());
    }
}
