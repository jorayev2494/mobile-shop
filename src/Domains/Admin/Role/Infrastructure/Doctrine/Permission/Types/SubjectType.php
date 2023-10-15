<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Doctrine\Permission\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Role\Domain\Permission\ValueObjects\PermissionSubject;

final class SubjectType extends Type
{
    public const NAME = 'admin_domain_role_permission_subject';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param PermissionSubject $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValueSQL($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value instanceof PermissionSubject ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): PermissionSubject
    {
        return PermissionSubject::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
