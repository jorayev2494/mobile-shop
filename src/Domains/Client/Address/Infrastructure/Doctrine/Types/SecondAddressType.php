<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressSecondAddress;

final class SecondAddressType extends Type
{
    public const NAME = 'client_domain_address_second_address';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param AddressSecondAddress $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): AddressSecondAddress
    {
        return AddressSecondAddress::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
