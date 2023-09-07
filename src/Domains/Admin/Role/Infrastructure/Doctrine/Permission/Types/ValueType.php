<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\PermissionValue;

final class ValueType extends Type
{
    public const NAME = 'admin_domain_role_permission_value';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param PermissionValue $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValueSQL($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value instanceof PermissionValue ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): PermissionValue
    {
        return PermissionValue::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
