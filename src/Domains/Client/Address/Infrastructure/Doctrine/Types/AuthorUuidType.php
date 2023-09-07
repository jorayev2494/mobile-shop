<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressAuthorUuid;

final class AuthorUuidType extends Type
{
    public const NAME = 'client_domain_address_author_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param AddressAuthorUuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): AddressAuthorUuid
    {
        return AddressAuthorUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
