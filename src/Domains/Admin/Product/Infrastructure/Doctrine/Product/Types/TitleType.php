<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductTitle;

final class TitleType extends Type
{
    public const NAME = 'admin_domain_product_price';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ProductTitle $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): ProductTitle
    {
        return ProductTitle::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
