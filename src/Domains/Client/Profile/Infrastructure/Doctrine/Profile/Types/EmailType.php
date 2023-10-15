<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Profile\Domain\Profile\ValueObjects\ProfileEmail;

class EmailType extends Type
{
    public const TYPE = 'profile_domain_profile_email';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ProfileEmail $value
     * @param AbstractPlatform $platform
     * @return void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ProfileEmail
    {
        return ProfileEmail::fromValue($value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
