<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\Create;
use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        // public readonly iterable $products,
        public readonly string $productUuid,
        public readonly int $productQuality,
    )
    {
        
    }
}
