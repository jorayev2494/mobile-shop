<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Commands\Toggle;

use Project\Shared\Domain\Bus\Command\CommandInterface;

final class ToggleFavoriteCommand implements CommandInterface
{
    public function __construct(
        public readonly string $memberUuid,
        public readonly string $productUuid,
    ) {

    }
}
