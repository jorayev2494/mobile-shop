<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\Confirm;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $cardUuid,
        public readonly string $addressUuid,
        public readonly string $currencyUuid,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?int $promoCode,
        public readonly ?string $note,
    ) {

    }
}
