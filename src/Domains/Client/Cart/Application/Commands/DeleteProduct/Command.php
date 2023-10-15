<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\DeleteProduct;

use Project\Shared\Domain\Bus\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        public readonly string $productUuid,
    ) {

    }
}
