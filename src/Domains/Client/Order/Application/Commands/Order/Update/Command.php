<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Order\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $clientUuid,
        public readonly string $cardUuid,
        public readonly string $addressUuid,
        public readonly string $currencyUuid,
        public readonly iterable $products,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $note,
    ) {

    }
}
