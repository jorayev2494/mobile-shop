<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    public readonly ?int $value;
    public function __construct(?int $value)
    {
        $this->value = $value;
    }

    public static function fromValue(int $value = null): static
    {
        return new static($value);
    }

    public function isEquals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->value !== $other->value;
    }

    public function isBiggerThan(self $other): bool
    {
        return $this->value > $other->value;
    }
}
