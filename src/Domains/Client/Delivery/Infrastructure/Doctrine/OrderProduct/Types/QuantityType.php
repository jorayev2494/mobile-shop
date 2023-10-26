<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\OrderProduct\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Delivery\Domain\OrderProduct\ValueObjects\Quantity;

final class QuantityType extends Type
{
    public const NAME = 'client_domain_delivery_order_product_quantity';

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
