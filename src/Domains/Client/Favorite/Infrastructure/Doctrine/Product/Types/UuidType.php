<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure\Doctrine\Product\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUuid;

final class UuidType extends Type
{
    public const NAME = 'client_domain_favorite_product_uuid';

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
        return $value->value;
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
