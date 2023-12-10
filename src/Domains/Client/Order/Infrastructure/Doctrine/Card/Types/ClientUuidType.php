<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Card\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ClientUuid;

final class ClientUuidType extends Type
{
    public const NAME = 'client_domain_order_card_client_uuid';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param ClientUuid $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ClientUuid
    {
        return ClientUuid::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
