<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;

final class UuidType extends Type
{
    public const NAME = 'admin_domain_product_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ProductUuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value instanceof ProductUuid ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): ProductUuid
    {
        return ProductUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
