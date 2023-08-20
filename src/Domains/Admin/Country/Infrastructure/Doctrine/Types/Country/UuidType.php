<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUuid;

class UuidType extends Type
{
    public const TYPE = 'admin_domain_country_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param CountryUuid $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        // dd($value);
        return $value->value;
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return CountryUuid
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): CountryUuid
    {
        // dd($value, CountryUuid::fromValue($value));
        return CountryUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
