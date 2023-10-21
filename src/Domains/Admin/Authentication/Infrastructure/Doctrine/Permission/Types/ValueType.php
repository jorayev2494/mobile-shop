<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects\Value;

final class ValueType extends Type
{
    public const NAME = 'admin_domain_role_permission_value';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Value $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValueSQL($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value instanceof Value ? $value->value : $value;
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
