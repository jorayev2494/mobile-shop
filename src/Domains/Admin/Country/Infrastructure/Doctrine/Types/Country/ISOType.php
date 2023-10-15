<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryISO;

class ISOType extends Type
{
    public const TYPE = 'admin_domain_country_iso';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param CountryISO $value
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
     * @return CountryISO
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): CountryISO
    {
        return CountryISO::fromValue($value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
