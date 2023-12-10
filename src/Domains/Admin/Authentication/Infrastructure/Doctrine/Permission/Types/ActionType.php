<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Permission\Types;

use Doctrine\DBAL\Types\Type;
use Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects\Action;

final class ActionType extends Type
{
    public const NAME = 'admin_domain_role_permission_action';

    public function getSQLDeclaration($column, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @param Action $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValueSQL($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function convertToPHPValue($value, \Doctrine\DBAL\Platforms\AbstractPlatform $platform): Action
    {
        return Action::fromValue($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}