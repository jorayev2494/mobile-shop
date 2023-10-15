<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Type;

final class TypeType extends \Doctrine\DBAL\Types\Type
{
    public const NAME = 'client_domain_order_card_type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Type $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Type
    {
        return Type::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
