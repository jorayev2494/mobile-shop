<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Domain\Permission\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

final class PermissionAction extends StringValueObject
{
    public function __toString(): string
    {
        return $this->value ?? '';
    }
}
