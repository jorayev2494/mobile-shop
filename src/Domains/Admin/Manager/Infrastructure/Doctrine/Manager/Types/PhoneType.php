<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Doctrine\Manager\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerPhone;

final class PhoneType extends Type
{
    public const NAME = 'admin_domain_manager_phone';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ManagerPhone $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ManagerPhone
    {
        return ManagerPhone::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
