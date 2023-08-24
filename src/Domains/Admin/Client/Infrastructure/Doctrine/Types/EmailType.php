<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientEmail;

class EmailType extends Type
{
    public const TYPE = 'admin_domain_client_email';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ClientEmail $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ClientEmail
    {
        return ClientEmail::fromValue($value);
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
