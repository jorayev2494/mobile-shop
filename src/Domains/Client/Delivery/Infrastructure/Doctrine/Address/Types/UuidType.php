<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\Uuid;

final class UuidType extends Type
{
    public const NAME = 'client_domain_delivery_address_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $value instanceof Uuid ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): Uuid
    {
        return Uuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
