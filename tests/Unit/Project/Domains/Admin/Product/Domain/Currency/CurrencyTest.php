<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Domain\Currency;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Currency\Currency;
use Project\Domains\Admin\Product\Domain\Currency\Events\CurrencyValueWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Currency\Events\CurrencyWasCreatedDomainEvent;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Value;
use Tests\Unit\Project\Domains\Admin\Product\Application\Currency\CurrencyFactory;

/**
 * @group currency
 * @group currency-domain
 */
class CurrencyTest extends TestCase
{
    public function testCreateCurrency(): void
    {
        $currency = Currency::create(
            Uuid::fromValue(CurrencyFactory::UUID),
            Value::fromValue(CurrencyFactory::CURRENCY),
            CurrencyFactory::IS_ACTIVE,
        );

        $this->assertInstanceOf(Uuid::class, $currency->getUuid());
        $this->assertSame(CurrencyFactory::UUID, $currency->getUuid()->value);

        $this->assertInstanceOf(Value::class, $currency->getValue());
        $this->assertSame(CurrencyFactory::CURRENCY, $currency->getValue()->value);

        $this->assertIsBool($isActive = $currency->getIsActive());
        $this->assertSame(CurrencyFactory::IS_ACTIVE, $isActive);

        $this->assertCount(1, $domainEvents = $currency->pullDomainEvents());
        $this->assertInstanceOf(CurrencyWasCreatedDomainEvent::class, $domainEvents[0]);
    }

    public function testCreateFromPrimitives(): void
    {
        $currency = Currency::fromPrimitives(
            CurrencyFactory::UUID,
            CurrencyFactory::CURRENCY,
            CurrencyFactory::IS_ACTIVE,
        );

        $this->assertInstanceOf(Uuid::class, $currency->getUuid());
        $this->assertSame(CurrencyFactory::UUID, $currency->getUuid()->value);

        $this->assertInstanceOf(Value::class, $currency->getValue());
        $this->assertSame(CurrencyFactory::CURRENCY, $currency->getValue()->value);

        $this->assertIsBool($isActive = $currency->getIsActive());
        $this->assertSame(CurrencyFactory::IS_ACTIVE, $isActive);

        $this->assertCount(0, $currency->pullDomainEvents());
    }

    public function testChangeCurrencyValue(): void
    {
        $currency = CurrencyFactory::make();

        $currency->changeValue($value = Value::fromValue('UAH'));

        $this->assertInstanceOf(Value::class, $currency->getValue());
        $this->assertSame($value->value, $currency->getValue()->value);

        $this->assertCount(1, $domainEvents = $currency->pullDomainEvents());
        $this->assertInstanceOf(CurrencyValueWasChangedDomainEvent::class, $domainEvents[0]);
    }

    public function testChangeCurrencyIsActive(): void
    {
        $currency = CurrencyFactory::make();

        $currency->changeIsActive(false);

        $this->assertIsBool($currency->getIsActive());
        $this->assertSame(false, $currency->getIsActive());

        $this->assertCount(0, $currency->pullDomainEvents());
    }
}
