<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\CVV;

final class CVVType extends Type
{
    public const NAME = 'client_domain_delivery_card_cvv';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    /**
     * @param CVV $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): CVV
    {
        return CVV::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
