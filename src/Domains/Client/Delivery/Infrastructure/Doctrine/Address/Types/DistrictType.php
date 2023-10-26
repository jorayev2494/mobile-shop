<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Delivery\Domain\Address\ValueObjects\District;

final class DistrictType extends Type
{
    public const NAME = 'client_domain_delivery_address_district';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param District $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): District
    {
        return District::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
