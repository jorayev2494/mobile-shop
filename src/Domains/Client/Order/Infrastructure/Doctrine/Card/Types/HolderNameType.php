<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\HolderName;

final class HolderNameType extends Type
{
    public const NAME = 'client_domain_order_card_holder_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param HolderName $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): HolderName
    {
        return HolderName::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
