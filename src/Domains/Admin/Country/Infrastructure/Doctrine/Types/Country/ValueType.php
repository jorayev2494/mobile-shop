<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryValue;

class ValueType extends Type
{
    const TYPE = 'admin_domain_country_value';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param CountryValue $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return CountryValue
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): CountryValue
    {
        return CountryValue::fromValue($value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
