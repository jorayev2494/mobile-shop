<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Commands\Update;

use Project\Shared\Application\Command\Command;
use Project\Shared\Domain\Bus\Command\CommandInterface;

final class UpdateOrderCommand extends Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly string $description,
        public readonly string $card_uuid,
        public readonly string $address_uuid,
        public readonly iterable $products,
        public readonly int $quality,
        public readonly float $sum,
        public readonly float $discard_sum,
    ) {

    }
}
