<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    public function __construct(
        public readonly string $value
    )
    {
        
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
    }

    // public function value(): string
    // {
    //     return $this->value;
    // }

}
