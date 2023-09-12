<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientFirstName;

final class FirstNameType extends Type
{
    public const NAME = 'admin_domain_client_first_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ClientFirstName $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ClientFirstName
    {
        return ClientFirstName::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
