<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types;

use Doctrine\DBAL\Types\Type;

use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\ZipCode;

final class ZipCodeType extends Type
{
    public const NAME = 'client_domain_delivery_address_zip_code';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param ZipCode $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return integer|null
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): ?int
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): ZipCode
    {
        return ZipCode::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
