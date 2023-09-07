<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\PermissionAction;

final class ActionType extends Type
{
    public const NAME = 'admin_domain_role_permission_action';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param PermissionAction $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return integer
     */
    public function convertToDatabaseValueSQL($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value instanceof PermissionAction ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): PermissionAction
    {
        return PermissionAction::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
