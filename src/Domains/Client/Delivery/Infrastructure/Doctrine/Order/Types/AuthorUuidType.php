<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\AuthorUuid;

final class AuthorUuidType extends Type
{
    public const NAME = 'client_domain_delivery_order_author_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param AuthorUuid $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): AuthorUuid
    {
        return AuthorUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
