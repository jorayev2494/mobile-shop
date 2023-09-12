<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientCountryUuid;

final class CountryUuidType extends Type
{
    public const NAME = 'admin_domain_client_country_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ?ClientCountryUuid $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return ! is_null($value) ? $value->value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ClientCountryUuid
    {
        return ClientCountryUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
