<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure;

use Project\Shared\Domain\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid as Uuid;

final class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
