<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\ExpirationDate;

final class ExpirationDateType extends Type
{
    public const NAME = 'client_domain_card_expiration_date';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ExpirationDate $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ExpirationDate
    {
        return ExpirationDate::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
