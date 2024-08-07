<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\PermissionId;

final class IdType extends Type
{
    public const NAME = 'admin_domain_role_permission_id';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param PermissionId $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return integer
     */
    public function convertToDatabaseValueSQL($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): int
    {
        return $value instanceof PermissionId ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): PermissionId
    {
        return PermissionId::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
