<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\OrderProduct\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\OrderProduct\ValueObjects\Quantity;

final class QuantityType extends Type
{
    public const NAME = 'client_domain_order_order_product_quantity';

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
