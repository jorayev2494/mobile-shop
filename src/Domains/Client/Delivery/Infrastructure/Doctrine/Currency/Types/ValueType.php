<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Currency\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Delivery\Domain\Currency\ValueObjects\Value;

final class ValueType extends Type
{
    public const NAME = 'client_domain_delivery_currency_domain_value';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Value $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): Value
    {
        return Value::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
