<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Address\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\CountryUuid;

final class CountryUuidType extends Type
{
    public const NAME = 'client_domain_order_address_country_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param CountryUuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): CountryUuid
    {
        return CountryUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
