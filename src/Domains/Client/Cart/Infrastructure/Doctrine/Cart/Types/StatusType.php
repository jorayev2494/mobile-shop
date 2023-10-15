<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\StatusEnum;

final class StatusType extends Type
{
    public const NAME = 'client_domain_cart_type';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param StatusEnum $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): StatusEnum
    {
        return StatusEnum::from($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
