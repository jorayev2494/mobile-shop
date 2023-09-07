<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;

final class UuidType extends Type
{
    public const NAME = 'client_domain_address_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $value instanceof AddressUuid ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): AddressUuid
    {
        return AddressUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
