<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Create;

use Project\Shared\Application\Command\Command;

final class CreateOrderCommand extends Command
{
    public function __construct(
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly string $description,

        public readonly iterable $products,

        public readonly int $quality,
        public readonly float $sum,
        public readonly float $discard_sum,
    )
    {
        
    }
}
