<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Address\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\SecondAddress;

final class SecondAddressType extends Type
{
    public const NAME = 'client_domain_order_address_second_address';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param SecondAddress $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): SecondAddress
    {
        return SecondAddress::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
