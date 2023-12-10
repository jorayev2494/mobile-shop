<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Client\Order\Domain\Address\Address;

class AddressFactory
{
    public const UUID = '0fd0e1cf-d706-470b-93b6-3346a0fe91f4';

    public const TITLE = 'Home address';

    public const FULL_NAME = 'Ivan Ivanov';

    public const FIRST_ADDRESS = 'First address';

    public const SECOND_ADDRESS = 'Second address';

    public const ZIP_CODE = 123456;

    public const COUNTRY_UUID = 'a63885a8-221b-41fb-bb86-089010adea57';

    public const CITY_UUID = 'eeec327c-dab4-4558-8e00-4f11fae66a8e';

    public const DISTRICT = 'District value';

    public static function make(
        string $uuid = null,
        string $title = null,
        string $fullName = null,
        string $authorUuid = null,
        string $firstAddress = null,
        string $secondAddress = null,
        int $zipCode = null,
        string $countryUuid = null,
        string $cityUuid = null,
        string $district = null,
    ): Address
    {
        return Address::fromPrimitives(
            $uuid ?? self::UUID,
            $title ?? self::TITLE,
            $fullName ?? self::FULL_NAME,
            $authorUuid ?? ClientFactory::UUID,
            $firstAddress ?? self::FIRST_ADDRESS,
            $secondAddress ?? self::SECOND_ADDRESS,
            $zipCode ?? self::ZIP_CODE,
            $countryUuid ?? self::COUNTRY_UUID,
            $cityUuid ?? self::CITY_UUID,
            $district ?? self::DISTRICT,
        );
    }
}
