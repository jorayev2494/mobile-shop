<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressTitle;

final class TitleType extends Type
{
    public const NAME = 'client_domain_address_title';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param AddressTitle $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
       return $value->value; 
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): AddressTitle
    {
        return AddressTitle::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
