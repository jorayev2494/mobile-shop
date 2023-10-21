<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects\Id;

final class IdType extends Type
{
    public const NAME = 'admin_domain_role_permission_id';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param Id $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return integer
     */
    public function convertToDatabaseValueSQL($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): int
    {
        return $value instanceof Id ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): Id
    {
        return Id::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
