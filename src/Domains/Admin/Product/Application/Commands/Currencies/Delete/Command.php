<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Currencies\Delete;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
    ) {

    }
}
