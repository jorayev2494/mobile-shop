<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfilePhone;

class PhoneType extends Type
{
    public const NAME = 'admin_domain_profile_phone';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ProfilePhone $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ProfilePhone
    {
        return ProfilePhone::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
