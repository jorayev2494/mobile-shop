<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Category\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Category\ValueObjects\Uuid;

final class UuidType extends Type
{
    public const NAME = 'client_domain_category_category_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Uuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value instanceof Uuid ? $value->value : $value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): Uuid
    {
        return Uuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
