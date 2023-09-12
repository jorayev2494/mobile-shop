<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Infrastructure\Doctrine\Category\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;

final class UuidType extends Type
{
    public const NAME = 'admin_domain_category_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param CategoryUuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value instanceof CategoryUuid ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): CategoryUuid
    {
        return CategoryUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
