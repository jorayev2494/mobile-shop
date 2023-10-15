<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Client\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\LastName;

final class LastNameType extends Type
{
    public const NAME = 'client_domain_cart_client_last_name';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param LastName $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): LastName
    {
        return LastName::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
