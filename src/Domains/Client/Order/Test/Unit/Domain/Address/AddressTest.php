<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Domain\Address;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\AuthorUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\CityUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\CountryUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\District;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\FirstAddress;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\FullName;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\SecondAddress;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Title;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\ZipCode;
use Project\Domains\Client\Order\Test\Unit\Application\AddressFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ClientFactory;
use Project\Shared\Domain\Aggregate\AggregateRoot;

/**
 * @group order-domain
 * @group order-address-domain
 */
class AddressTest extends TestCase
{
    private Address $address;

    protected function setUp(): void
    {
        $this->address = AddressFactory::make();
    }

    public function testCreate(): void
    {
        $address = Address::create(
            Uuid::fromValue(AddressFactory::UUID),
            Title::fromValue(AddressFactory::TITLE),
            FullName::fromValue(AddressFactory::FULL_NAME),
            AuthorUuid::fromValue(ClientFactory::UUID),
            FirstAddress::fromValue(AddressFactory::FIRST_ADDRESS),
            SecondAddress::fromValue(AddressFactory::SECOND_ADDRESS),
            ZipCode::fromValue(AddressFactory::ZIP_CODE),
            CountryUuid::fromValue(AddressFactory::COUNTRY_UUID),
            CityUuid::fromValue(AddressFactory::CITY_UUID),
            District::fromValue(AddressFactory::DISTRICT),
        );

        $this->assertNotNull($address);
        $this->assertInstanceOf(Address::class, $address);
        $this->assertInstanceOf(AggregateRoot::class, $address);

        $this->assertInstanceOf(Uuid::class, $address->getUuid());
        $this->assertSame(AddressFactory::UUID, $address->getUuid()->value);

        $this->assertInstanceOf(Title::class, $address->getTitle());
        $this->assertSame(AddressFactory::TITLE, $address->getTitle()->value);

        $this->assertInstanceOf(FullName::class, $address->getFullName());
        $this->assertSame(AddressFactory::FULL_NAME, $address->getFullName()->value);

        $this->assertInstanceOf(AuthorUuid::class, $address->getAuthorUuid());
        $this->assertSame(ClientFactory::UUID, $address->getAuthorUuid()->value);

        $this->assertInstanceOf(FirstAddress::class, $address->getFirstAddress());
        $this->assertSame(AddressFactory::FIRST_ADDRESS, $address->getFirstAddress()->value);

        $this->assertInstanceOf(SecondAddress::class, $address->getSecondAddress());
        $this->assertSame(AddressFactory::SECOND_ADDRESS, $address->getSecondAddress()->value);

        $this->assertInstanceOf(ZipCode::class, $address->getZipCode());
        $this->assertSame(AddressFactory::ZIP_CODE, $address->getZipCode()->value);

        $this->assertInstanceOf(CountryUuid::class, $address->getCountryUuid());
        $this->assertSame(AddressFactory::COUNTRY_UUID, $address->getCountryUuid()->value);

        $this->assertInstanceOf(CityUuid::class, $address->getCityUuid());
        $this->assertSame(AddressFactory::CITY_UUID, $address->getCityUuid()->value);

        $this->assertInstanceOf(District::class, $address->getDistrict());
        $this->assertSame(AddressFactory::DISTRICT, $address->getDistrict()->value);

        $this->assertEmpty($domainEvents = $address->pullDomainEvents());
        $this->assertCount(0, $domainEvents);
    }

    public function testAddressChangeTitle(): void
    {
        $this->assertInstanceOf(Title::class, $this->address->getTitle());
        $this->assertSame(AddressFactory::TITLE, $this->address->getTitle()->value);

        $this->address->changeTitle(Title::fromValue('New Title'));

        $this->assertInstanceOf(Title::class, $this->address->getTitle());
        $this->assertNotSame(AddressFactory::TITLE, $this->address->getTitle()->value);
        $this->assertSame('New Title', $this->address->getTitle()->value);
    }

    public function testAddressChangeFullName(): void
    {
        $this->assertInstanceOf(FullName::class, $this->address->getFullName());
        $this->assertSame(AddressFactory::FULL_NAME, $this->address->getFullName()->value);

        $this->address->changeFullName(FullName::fromValue('Change FullName'));

        $this->assertInstanceOf(FullName::class, $this->address->getFullName());
        $this->assertNotSame(AddressFactory::FULL_NAME, $this->address->getFullName()->value);
        $this->assertSame('Change FullName', $this->address->getFullName()->value);
    }

    public function testAddressChangeFirstAddress(): void
    {
        $this->assertInstanceOf(FirstAddress::class, $this->address->getFirstAddress());
        $this->assertSame(AddressFactory::FIRST_ADDRESS, $this->address->getFirstAddress()->value);

        $this->address->changeFirstAddress(FirstAddress::fromValue('Change Fist Address'));

        $this->assertInstanceOf(FirstAddress::class, $this->address->getFirstAddress());
        $this->assertNotSame(AddressFactory::FIRST_ADDRESS, $this->address->getFirstAddress()->value);
        $this->assertSame('Change Fist Address', $this->address->getFirstAddress()->value);
    }

    public function testAddressChangeSecondAddress(): void
    {
        $this->assertInstanceOf(SecondAddress::class, $this->address->getSecondAddress());
        $this->assertSame(AddressFactory::SECOND_ADDRESS, $this->address->getSecondAddress()->value);

        $this->address->changeSecondAddress(SecondAddress::fromValue('Change Second Address'));

        $this->assertInstanceOf(SecondAddress::class, $this->address->getSecondAddress());
        $this->assertNotSame(AddressFactory::SECOND_ADDRESS, $this->address->getSecondAddress()->value);
        $this->assertSame('Change Second Address', $this->address->getSecondAddress()->value);
    }

    public function testAddressChangeZipCode(): void
    {
        $this->assertInstanceOf(ZipCode::class, $this->address->getZipCode());
        $this->assertSame(AddressFactory::ZIP_CODE, $this->address->getZipCode()->value);

        $this->address->changeZipCode(ZipCode::fromValue(100100));

        $this->assertInstanceOf(ZipCode::class, $this->address->getZipCode());
        $this->assertNotSame(AddressFactory::ZIP_CODE, $this->address->getZipCode()->value);
        $this->assertSame(100100, $this->address->getZipCode()->value);
    }

    public function testAddressChangeCountryUuid(): void
    {
        $this->assertInstanceOf(CountryUuid::class, $this->address->getCountryUuid());
        $this->assertSame(AddressFactory::COUNTRY_UUID, $this->address->getCountryUuid()->value);

        $this->address->changeCountryUuid(CountryUuid::fromValue('9e632a64-da86-4a04-a420-4209070eab7a'));

        $this->assertInstanceOf(CountryUuid::class, $this->address->getCountryUuid());
        $this->assertNotSame(AddressFactory::COUNTRY_UUID, $this->address->getCountryUuid()->value);
        $this->assertSame('9e632a64-da86-4a04-a420-4209070eab7a', $this->address->getCountryUuid()->value);
    }

    public function testAddressChangeCityUuid(): void
    {
        $this->assertInstanceOf(CityUuid::class, $this->address->getCityUuid());
        $this->assertSame(AddressFactory::CITY_UUID, $this->address->getCityUuid()->value);

        $this->address->changeCityUuid(CityUuid::fromValue('76d3bff9-ef67-4b98-bb21-07e0189cb0c5'));

        $this->assertInstanceOf(CityUuid::class, $this->address->getCityUuid());
        $this->assertNotSame(AddressFactory::CITY_UUID, $this->address->getCityUuid()->value);
        $this->assertSame('76d3bff9-ef67-4b98-bb21-07e0189cb0c5', $this->address->getCityUuid()->value);
    }

    public function testAddressChangeDistrict(): void
    {
        $this->assertInstanceOf(District::class, $this->address->getDistrict());
        $this->assertSame(AddressFactory::DISTRICT, $this->address->getDistrict()->value);

        $this->address->changeDistrict(District::fromValue('Change District name'));

        $this->assertInstanceOf(District::class, $this->address->getDistrict());
        $this->assertNotSame(AddressFactory::DISTRICT, $this->address->getDistrict()->value);
        $this->assertSame('Change District name', $this->address->getDistrict()->value);
    }
}
