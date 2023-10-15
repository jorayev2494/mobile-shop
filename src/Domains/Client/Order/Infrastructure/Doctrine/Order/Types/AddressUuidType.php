<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\AddressUuid;

final class AddressUuidType extends Type
{
    public const NAME = 'client_domain_order_address_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param AddressUuid $value
     * @param AbstractPlatform $platform
     * @return void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): AddressUuid
    {
        return AddressUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
