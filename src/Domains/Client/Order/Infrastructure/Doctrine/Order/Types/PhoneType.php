<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Phone;

final class PhoneType extends Type
{
    public const NAME = 'client_domain_order_phone';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Phone $value
     * @param AbstractPlatform $platform
     * @return void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Phone
    {
        return Phone::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
