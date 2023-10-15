<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientLastName;

final class LastNameType extends Type
{
    public const NAME = 'admin_domain_client_last_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ClientLastName $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ClientLastName
    {
        return ClientLastName::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
