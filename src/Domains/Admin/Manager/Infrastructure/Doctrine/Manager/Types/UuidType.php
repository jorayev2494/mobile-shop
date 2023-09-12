<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;

final class UuidType extends Type
{
    public const NAME = 'admin_domain_manager_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ManagerUuid $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof ManagerUuid ? $value->value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ManagerUuid
    {
        return ManagerUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
