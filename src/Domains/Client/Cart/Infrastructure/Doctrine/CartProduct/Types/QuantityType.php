<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Doctrine\CartProduct\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Cart\Domain\CartProduct\ValueObjects\Quantity;

final class QuantityType extends Type
{
    public const NAME = 'client_domain_cart_cart_product_quantity';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param Quantity $value
     * @param AbstractPlatform $platform
     * @return integer
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Quantity
    {
        return Quantity::fromValue((int) $value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
