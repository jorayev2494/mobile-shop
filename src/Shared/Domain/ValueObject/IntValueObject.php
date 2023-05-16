<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    public function __construct(
        public readonly ?int $value
    )
    {
        
    }

    public static function fromValue(int $value = null): static
    {
        return new static($value);
    }

    public function isBiggerThan(self $other): bool
    {
        return $this->value > $other->value;
    }
}
