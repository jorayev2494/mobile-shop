<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

// use Doctrine\DBAL\Types\Types;
// use Doctrine\ORM\Mapping as ORM;

abstract class IntValueObject
{

    // #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private readonly ?int $value;
    public function __construct(?int $value)
    {
        $this->value = $value;
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
