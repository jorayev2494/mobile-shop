<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\CurrencyUuid;

final class UuidType extends Type
{
    public const NAME = 'currency_domain_currency_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param CurrencyUuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): CurrencyUuid
    {
        return CurrencyUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
