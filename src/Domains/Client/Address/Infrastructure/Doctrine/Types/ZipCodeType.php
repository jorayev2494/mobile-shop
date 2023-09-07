<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressZipCode;

final class ZipCodeType extends Type
{
    public const NAME = 'client_domain_address_zip_code';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param AddressZipCode $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return integer|null
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): ?int
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): AddressZipCode
    {
        return AddressZipCode::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
