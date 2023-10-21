<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Permission\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;

final class Value extends StringValueObject
{
    public function __toString(): string
    {
        return $this->value;
    }
}
