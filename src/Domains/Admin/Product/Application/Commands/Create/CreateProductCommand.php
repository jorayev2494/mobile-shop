<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Create;

use Project\Shared\Application\Command\Command;
use Project\Shared\Domain\Bus\Command\CommandInterface;

final class CreateProductCommand extends Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        public readonly string $categoryUUID,
        public readonly string $currencyUUID,
        public readonly string $price,
        public readonly int $discountPercentage,
        public readonly iterable $medias,
        public readonly string $description,
        public readonly bool $isActive,
    )
    {

    }
}
