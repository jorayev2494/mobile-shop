<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Infrastructure\Doctrine\Category\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryValue;

final class ValueType extends Type
{
    public const NAME = 'admin_domain_category_value';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param CategoryValue $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): CategoryValue
    {
        return CategoryValue::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
