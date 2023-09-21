<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

// use Doctrine\DBAL\Types\Types;
// use Doctrine\ORM\Mapping as ORM;

abstract class StringValueObject implements \Stringable
{
    // #[ORM\Column(type: Types::STRING)]
    public ?string $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    public static function fromValue(?string $value): static
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

    public function isNull(): bool
    {
        return is_null($this->value);
    }

    public function isNotNull(): bool
    {
        return ! is_null($this->value);
    }

    // public function setValue(string $value): void
    // {
    //     $this->value = $value;
    // }

    // public function value(): string
    // {
    //     return $this->value;
    // }

    public function __toString(): string
    {
        return $this->value;
    }

}
