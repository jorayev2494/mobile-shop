<?php

declare(strict_types=1);

namespace Project\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UuidValueObject
{
    protected function __construct(
        public readonly string $value
    )
    {
        $this->assertIsValidUuid($value);
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4()->toString());
    }

    public static function fromValue(string $value): static
    {
        return new static($value);
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    private function assertIsValidUuid(string $id): void
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('`<%s>` does not allow the value `<%s>`.', static::class, $id));
        }
    }
}
