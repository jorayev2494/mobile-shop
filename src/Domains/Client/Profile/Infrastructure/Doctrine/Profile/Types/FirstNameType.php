<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Infrastructure\Doctrine\Profile\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Profile\Domain\Profile\ValueObjects\ProfileFirstName;

class FirstNameType extends Type
{
    public const TYPE = 'profile_domain_profile_first_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ProfileFirstName $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ProfileFirstName
    {
        return ProfileFirstName::fromValue($value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
