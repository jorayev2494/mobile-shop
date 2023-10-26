<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\Note;

final class NoteType extends Type
{
    public const NAME = 'client_domain_delivery_order_note';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Note $value
     * @param AbstractPlatform $platform
     * @return void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Note
    {
        return Note::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
