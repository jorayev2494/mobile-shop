<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;

final class UuidType extends Type
{
    public const NAME = 'client_domain_order_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Uuid $value
     * @param AbstractPlatform $platform
     * @return void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        // dump($value, get_called_class());
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Uuid
    {
        return Uuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
