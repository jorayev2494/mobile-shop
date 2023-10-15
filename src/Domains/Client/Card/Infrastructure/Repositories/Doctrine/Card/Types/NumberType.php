<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Number;

final class NumberType extends Type
{
    public const NAME = 'client_domain_card_number';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Number $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Number
    {
        return Number::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
