<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Doctrine\Types;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleValue;

final class ValueType extends Type
{
    public const NAME = 'admin_domain_role_value';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param RoleValue $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): RoleValue
    {
        return RoleValue::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
