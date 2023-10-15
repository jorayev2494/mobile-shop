<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure\Doctrine\Member\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;

final class UuidType extends Type
{
    public const NAME = 'client_domain_favorite_member_uuid';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param MemberUuid $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): MemberUuid
    {
        return MemberUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
