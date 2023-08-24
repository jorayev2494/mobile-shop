<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;

class UuidType extends Type
{
    public const TYPE = 'admin_domain_client_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ClientUuid $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof ClientUuid ? $value->value : $value;
    }

    /**
     * @param ?string $value
     * @param AbstractPlatform $platform
     * @return ClientUuid
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ClientUuid
    {
        return ClientUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
