<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Description;

final class DescriptionType extends Type
{
    public const NAME = 'client_domain_cart_product_description';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Description $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): Description
    {
        return Description::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
